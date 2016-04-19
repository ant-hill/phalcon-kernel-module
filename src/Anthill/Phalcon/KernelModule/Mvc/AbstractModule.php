<?php

namespace Anthill\Phalcon\KernelModule\Mvc;


use Anthill\Phalcon\KernelModule\DependencyInjection\Loader;
use Anthill\Phalcon\KernelModule\DependencyInjection\LoaderInterface;
use Phalcon\Config;
use Phalcon\Mvc\ModuleDefinitionInterface;

abstract class AbstractModule implements ModuleDefinitionInterface
{

    /**
     * @var Config
     */
    private $config;

    public function setConfig(Config $config)
    {
        $this->config = $config;
    }

    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Get config path
     * @return string
     */
    abstract public function getModuleName();

    /**
     * Get config path
     * @return string
     */
    abstract public function getConfigPath();

    /**
     * @return string
     */
    abstract public function getServicesPath();

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
        $configArray = [];
        $servicePath = null;

        if (file_exists($this->getConfigPath())) {
            $configArray = include $this->getConfigPath();
        }

        $config = $this->buildConfig($configArray);

        if (file_exists($this->getServicesPath())) {
            $servicePath = include $this->getServicesPath();
        }
        $this->buildServices($dependencyInjector, $config, $servicePath);
    }

    protected function buildServices(\Phalcon\DiInterface $dependencyInjector, Config $config, $servicePath)
    {
        $loader = new Loader($dependencyInjector, $config);
        $loader->load($servicePath);
    }

    /**
     * @param $configArray
     * @return Config
     */
    protected function buildConfig($configArray)
    {
        $moduleNamespace = $this->getModuleName();
        $value = null;
        $newConfig = new Config($configArray);
        $newConfig->merge($this->getConfig());
        if ($newConfig->offsetExists($moduleNamespace)) {
            $value = $newConfig->get($moduleNamespace);
        }
        $config = new Config();
        $config->offsetSet($moduleNamespace, $value);
        return $config;
    }
}