<?php

namespace Anthill\Phalcon\KernelModule;


use Anthill\Phalcon\KernelModule\ConfigLoader\LoaderFactory;
use Anthill\Phalcon\KernelModule\DependencyInjection\Loader;
use Anthill\Phalcon\KernelModule\Mvc\AbstractModule;
use Phalcon\Config;
use Phalcon\Di;
use Phalcon\DiInterface;

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

        $this->config = $this->registerConfiguration(new LoaderFactory());

        if (!$this->getDI()) {
            $this->setDI(new Di());
        }

        foreach ($this->registerModules() as $module) {
            if ($module instanceof AbstractModule) {
                $module->setConfig($this->config);
            }
            $module->registerServices($this->getDI());
            $module->registerAutoloaders($this->getDI());
        }
        $this->registerServices();

        $this->isBooted = true;
    }

    /**
     * @param LoaderFactory $loader
     * @return Config
     */
    abstract public function registerConfiguration(LoaderFactory $loader);

    /**
     * @return DiInterface
     */
    public function getDI()
    {
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
        $loader = new Loader($this->getDI(), $this->config);
        $loader->load($this->config->get('services'));
    }

    public function getConfig()
    {
        return $this->config;
    }
}