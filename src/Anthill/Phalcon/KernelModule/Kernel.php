<?php

namespace Anthill\Phalcon\KernelModule;


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
        $this->config = $this->registerConfiguration(new Config\Loader());

        if (!$this->getDI()) {
            $this->setDI(new Di\FactoryDefault());
        }

        foreach ($this->registerModules() as $module) {
            if($module instanceof AbstractModule){
                $module->setConfig($this->config);
            }
            $module->registerServices($this->getDI());
            $module->registerAutoloaders($this->getDI());
        }

        $this->isBooted = true;
    }

    /**
     * @param DiInterface $dependencyInjector
     */
    public function setDI(DiInterface $dependencyInjector)
    {
        $this->dependencyInjector = $dependencyInjector;
    }

    /**
     * @return DiInterface
     */
    public function getDI()
    {
        return $this->dependencyInjector;
    }

    /**
     * @param Config\Loader $loader
     * @return Config
     */
    abstract public function registerConfiguration(\Phalcon\Config\Loader $loader);

    public function getConfig()
    {
        return $this->config;
    }
}