<?php
namespace Tests\Anthill\Phalcon\KernelModule\DependencyInjection\Fixtures\Di;

use Anthill\Phalcon\KernelModule\ConfigLoader\LoaderFactoryInterface;
use Anthill\Phalcon\KernelModule\Mvc\AbstractModule;
use Phalcon\Config;

class ServiceLoaderFixture extends AbstractModule
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
        return $loader->load(__DIR__ . '/../config.php');
    }

    /**
     * @param LoaderFactoryInterface $loader
     * @return Config
     */
    public function getServicesConfig(LoaderFactoryInterface $loader)
    {
        return $loader->load(__DIR__ . '/../services.php');
    }
}