<?php

namespace Anthill\Phalcon\KernelModule;

use Anthill\Phalcon\KernelModule\ConfigLoader\LoaderFactoryInterface;
use Phalcon\Config;
use Phalcon\Di\InjectionAwareInterface;
use Phalcon\Mvc\ModuleDefinitionInterface;

/**
 * Interface KernelInterface
 * @package Anthill\Phalcon\KernelModule
 */
interface KernelInterface extends InjectionAwareInterface
{
    /**
     * @return ModuleDefinitionInterface[]
     */
    public function registerModules();

    /**
     * @return void
     */
    public function registerRoutes();

    /**
     * @return Config
     */
    public function getConfig();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getVersion();

    /**
     * @return string
     */
    public function getEnvironment();

    /**
     * @return string
     */
    public function getRootDir();

    /**
     * @return LoaderFactoryInterface
     */
    public function getConfigLoader();

    /**
     * @param Config $config
     * @return Config
     */
    public function mergeConfig(Config $config);

    public function boot();
}