<?php
namespace Tests\Anthill\Phalcon\KernelModule\Module\Fixtures;

use Anthill\Phalcon\KernelModule\ConfigLoader\LoaderFactoryInterface;
use Anthill\Phalcon\KernelModule\Module\AbstractModule;
use Phalcon\Config;

class ModuleFixture extends AbstractModule
{
    private $configPath;
    private $servicesPath;

    /**
     * @return mixed
     */
    public function getConfigPath()
    {
        if (!$this->configPath) {
            $this->configPath = __DIR__ . '/config.php';
        }

        return $this->configPath;
    }

    /**
     * @param mixed $configPath
     */
    public function setConfigPath($configPath)
    {
        $this->configPath = $configPath;
    }

    /**
     * @return mixed
     */
    public function getServicesPath()
    {
        if (!$this->servicesPath) {
            $this->servicesPath = __DIR__ . '/services.php';
        }
        return $this->servicesPath;
    }

    /**
     * @param mixed $servicesPath
     */
    public function setServicesPath($servicesPath)
    {
        $this->servicesPath = $servicesPath;
    }

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
        return $loader->load($this->getConfigPath());
    }

    /**
     * @param LoaderFactoryInterface $loader
     * @return Config
     */
    public function getServicesConfig(LoaderFactoryInterface $loader)
    {
        return $loader->load($this->getServicesPath());
    }
}