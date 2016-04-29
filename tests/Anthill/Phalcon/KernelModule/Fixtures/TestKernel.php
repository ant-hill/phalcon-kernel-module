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

    private $rootDir = __DIR__;
    private $modules = [];
    private $configPath = [];

    /**
     * @return array
     */
    public function getModules()
    {
        return $this->modules;
    }

    /**
     * @param array $modules
     */
    public function setModules($modules)
    {
        $this->modules = $modules;
    }

    /**
     * @return array
     */
    public function getConfigPath()
    {
        if (!$this->configPath) {
            $this->configPath = $this->getRootDir() . '/config.php';
        }
        return $this->configPath;
    }

    /**
     * @param string $configPath
     */
    public function setConfigPath($configPath)
    {
        $this->configPath = $configPath;
    }

    /**
     * @param string $rootDir
     */
    public function setRootDir($rootDir)
    {
        $this->rootDir = $rootDir;
    }

    /**
     * @param LoaderFactoryInterface $loader
     * @return Config
     * @throws \Anthill\Phalcon\KernelModule\ConfigLoader\Exceptions\LoaderException
     */
    public function registerConfiguration(LoaderFactoryInterface $loader)
    {
        return $loader->load($this->getConfigPath());
    }

    /**
     * @return string
     */
    public function getRootDir()
    {
        return $this->rootDir;
    }

    /**
     * @return ModuleDefinitionInterface[]
     */
    public function registerModules()
    {
        return $this->getModules();
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