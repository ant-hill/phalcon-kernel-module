<?php

namespace Anthill\Phalcon\KernelModule\Module;


use Anthill\Phalcon\KernelModule\ConfigLoader\LoaderFactoryInterface;
use Anthill\Phalcon\KernelModule\DependencyInjection\LoaderInterface;
use Anthill\Phalcon\KernelModule\DependencyInjection\ServiceLoader;
use Anthill\Phalcon\KernelModule\KernelInterface;
use Phalcon\Config;
use Phalcon\Mvc\ModuleDefinitionInterface;

abstract class AbstractModule implements ModuleDefinitionInterface
{

    /**
     * @var \Anthill\Phalcon\KernelModule\ConfigLoader\LoaderFactoryInterface
     */
    private $loader;

    /**
     * @var KernelInterface
     */
    private $kernelInterface;

    /**
     * @var LoaderInterface
     */
    private $serviceLoader;

    /**
     * @return KernelInterface
     */
    public function getKernelInterface()
    {
        return $this->kernelInterface;
    }

    /**
     * @param KernelInterface $kernelInterface
     */
    public function setKernelInterface($kernelInterface)
    {
        $this->kernelInterface = $kernelInterface;
    }

    /**
     * @return ServiceLoader
     */
    private function getDefaultServiceLoader()
    {
        return new ServiceLoader($this->getKernel());
    }

    /**
     * @return LoaderInterface
     */
    public function getServiceLoader()
    {
        if (!$this->serviceLoader) {
            return $this->serviceLoader = $this->getDefaultServiceLoader();
        }
        return $this->serviceLoader;
    }

    /**
     * @param LoaderInterface $serviceLoader
     */
    public function setServiceLoader(LoaderInterface $serviceLoader)
    {
        $this->serviceLoader = $serviceLoader;
    }

    /**
     * @return KernelInterface
     */
    public function getKernel()
    {
        return $this->kernelInterface;
    }

    /**
     * @return \Anthill\Phalcon\KernelModule\ConfigLoader\LoaderFactoryInterface
     */
    public function getLoader()
    {
        return $this->loader;
    }

    public function __construct(KernelInterface $kernelInterface)
    {
        $this->loader = $kernelInterface->getConfigLoader();
        $this->kernelInterface = $kernelInterface;
    }

    /**
     * Get config path
     * @return string
     */
    abstract public function getModuleName();

    /**
     * Get config path
     * @param LoaderFactoryInterface $loader
     * @return Config|null
     */
    abstract public function getConfig(LoaderFactoryInterface $loader);

    /**
     * @param LoaderFactoryInterface $loader
     * @return Config|null
     */
    abstract public function getServicesConfig(LoaderFactoryInterface $loader);

    /**
     * Registers an autoloader related to the module
     *
     * @param mixed $dependencyInjector
     */
    public function registerAutoloaders(\Phalcon\DiInterface $dependencyInjector = null)
    {
        // TODO: Implement registerAutoloaders() method.
    }

    /**
     * Registers services related to the module
     *
     * @param mixed $dependencyInjector
     */
    public function registerServices(\Phalcon\DiInterface $dependencyInjector)
    {
        $config = $this->getConfig($this->getLoader());
        if ($config) {
            $this->getKernel()->mergeConfig($config);
        }
        $servicesConfig = $this->getServicesConfig($this->getLoader());
        if (!$servicesConfig) {
            return;
        }
        $loader = $this->getServiceLoader();
        $loader->load($servicesConfig);
    }
}