<?php

namespace Anthill\Phalcon\KernelModule;


use Anthill\Phalcon\KernelModule\ConfigLoader\LoaderFactory;
use Anthill\Phalcon\KernelModule\ConfigLoader\LoaderFactoryInterface;
use Anthill\Phalcon\KernelModule\DependencyInjection\ServiceLoader;
use Anthill\Phalcon\KernelModule\Router\RouterResolver;
use Phalcon\Config;
use Phalcon\Di;
use Phalcon\DiInterface;
use Rwillians\Stingray\Stingray;

abstract class Kernel implements KernelInterface
{
    /**
     * @var string
     */
    private $environment;

    /**
     * @var DiInterface
     */
    private $dependencyInjector;

    /**
     * @var Config
     */
    private $config;

    /**
     * @var bool
     */
    private $isBooted = false;

    /**
     * @var LoaderFactoryInterface
     */
    private $configLoader;

    protected function getDefaultConfigLoader()
    {
        return new LoaderFactory();
    }

    /**
     * @return LoaderFactoryInterface
     */
    public function getConfigLoader()
    {
        if (!$this->configLoader) {
            $this->configLoader = $this->getDefaultConfigLoader();
        }
        return $this->configLoader;
    }

    /**
     * Kernel constructor.
     * @param $environment
     */
    public function __construct($environment)
    {
        $this->environment = $environment;
    }

    /**
     * @return string
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    public function boot()
    {
        if ($this->isBooted) {
            return;
        }
        $loader = $this->getConfigLoader();
        $this->config = $this->registerConfiguration($loader);
        foreach ($this->registerModules() as $module) {
            $module->registerAutoloaders($this->getDI());
            $module->registerServices($this->getDI());
        }

        $this->registerServices();

        $this->isBooted = true;
    }

    /**
     * @param LoaderFactoryInterface $loader
     * @return Config
     * @throws \Anthill\Phalcon\KernelModule\ConfigLoader\Exceptions\LoaderException
     */
    abstract public function registerConfiguration(LoaderFactoryInterface $loader);

    /**
     * @return DiInterface
     */
    protected function getDefaultDI()
    {
        return new Di();
    }


    /**
     * @return DiInterface
     */
    public function getDI()
    {
        if (!$this->dependencyInjector) {
            $this->dependencyInjector = $this->getDefaultDI();
        }

        return $this->dependencyInjector;
    }

    /**
     * @param DiInterface $dependencyInjector
     */
    public function setDI(DiInterface $dependencyInjector)
    {
        $this->dependencyInjector = $dependencyInjector;
    }

    protected function registerServices()
    {
        // todo: think about misambugous
        $loader = new ServiceLoader($this);
        $loader->load($this->config->get('services'));
    }

    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param Config $config
     * @return Config
     */
    public function mergeConfig(Config $config)
    {
        $this->config = $config->merge($this->config);
        return $this->config;
    }

    public function registerRoutes()
    {
        /* @var $resolver RouterResolver */
        $resolver = $this->getDI()->get('route_resolver');
        $routesConfig = Stingray::get($this->getConfig()->toArray(), 'framework.routes');
        $resolver->resolve($routesConfig);
    }
}