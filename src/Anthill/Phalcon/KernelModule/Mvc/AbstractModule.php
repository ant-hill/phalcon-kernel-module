<?php

namespace Anthill\Phalcon\KernelModule\Mvc;


use Anthill\Phalcon\KernelModule\ConfigLoader\LoaderFactoryInterface;
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
     * @return Config
     */
    abstract public function getConfig(LoaderFactoryInterface $loader);

    /**
     * @param LoaderFactoryInterface $loader
     * @return Config
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
        $this->getKernel()->mergeConfig($this->getConfig($this->getLoader()));
        $servicePath = $this->getServicesConfig($this->getLoader());
        $loader = new ServiceLoader($this->getKernel());
        $loader->load($servicePath);
    }
}