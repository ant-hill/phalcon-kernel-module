<?php

namespace Anthill\Phalcon\KernelModule;

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

    public function boot();
}