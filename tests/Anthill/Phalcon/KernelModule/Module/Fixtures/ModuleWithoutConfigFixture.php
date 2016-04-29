<?php
namespace Tests\Anthill\Phalcon\KernelModule\Module\Fixtures;

use Anthill\Phalcon\KernelModule\ConfigLoader\LoaderFactoryInterface;
use Anthill\Phalcon\KernelModule\Module\AbstractModule;
use Phalcon\Config;

class ModuleWithoutConfigFixture extends AbstractModule
{

    /**
     * Get config path
     * @return string
     */
    public function getModuleName()
    {
        return 'module_fixture';
    }

    /**
     * Get config path
     * @param LoaderFactoryInterface $loader
     * @return Config
     */
    public function getConfig(LoaderFactoryInterface $loader)
    {
    }

    /**
     * @param LoaderFactoryInterface $loader
     * @return Config
     */
    public function getServicesConfig(LoaderFactoryInterface $loader)
    {
        return $loader->load(__DIR__ . '/services.php');
    }
}