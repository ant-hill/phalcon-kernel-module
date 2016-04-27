<?php

namespace Tests\Anthill\Phalcon\KernelModule\Fixtures;

use Anthill\Phalcon\KernelModule\ConfigLoader\LoaderFactoryInterface;
use Anthill\Phalcon\KernelModule\Kernel;
use Phalcon\Config;
use Phalcon\Mvc\ModuleDefinitionInterface;

/**
 * @RoutePrefix("/")
 */

class TestKernel extends Kernel
{

    /**
     * @param LoaderFactoryInterface $loader
     * @return Config
     */
    public function registerConfiguration(LoaderFactoryInterface $loader)
    {
        return $loader->load($this->getRootDir() . '/config.php');
    }

    /**
     * @return string
     */
    public function getRootDir()
    {
        return __DIR__;
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
}