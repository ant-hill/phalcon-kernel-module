<?php

namespace Tests\Anthill\Phalcon\KernelModule\Fixtures;


use Anthill\Phalcon\KernelModule\Kernel;
use Phalcon\Config;
use Phalcon\Mvc\ModuleDefinitionInterface;

class TestKernel extends Kernel
{

    /**
     * @param Config\Loader $loader
     * @return Config
     */
    public function registerConfiguration(\Phalcon\Config\Loader $loader)
    {
        return $loader::load($this->getRootDir() . '/config.php');
    }

    /**
     * @return ModuleDefinitionInterface[]
     */
    public function registerModules()
    {
        return array();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'testName';
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return '0.1.0';
    }

    /**
     * @return string
     */
    public function getRootDir()
    {
        return __DIR__;
    }
}