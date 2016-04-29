<?php

namespace Anthill\Phalcon\KernelModule\DependencyInjection;

use Anthill\Phalcon\KernelModule\DependencyInjection\Exceptions\ConfigParseException;
use Anthill\Phalcon\KernelModule\KernelInterface;
use Phalcon\Config;
use Phalcon\Di\InjectionAwareInterface;
use Phalcon\DiInterface;
use Rwillians\Stingray\Stingray;

class ServiceLoader implements LoaderInterface, InjectionAwareInterface
{
    /**
     * @var DiInterface
     */
    private $di;
    /**
     * @var Config
     */
    private $config;

    /**
     * @var KernelInterface
     */
    private $kernel;

    /**
     * @var \Anthill\Phalcon\KernelModule\ConfigLoader\LoaderFactoryInterface
     */
    private $configLoader;

    /**
     * ConfigLoader constructor.
     * @param KernelInterface $kernelInterface
     */
    public function __construct(KernelInterface $kernelInterface)
    {
        $this->kernel = $kernelInterface;
        $this->configLoader = $kernelInterface->getConfigLoader();
        $this->di = $kernelInterface->getDI();
        $this->config = $kernelInterface->getConfig();
    }

    /**
     * @param Config $config
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }

    /**
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * {@inheritdoc}
     */
    public function load($serviceConfig)
    {
        if (!$serviceConfig instanceof Config) {
            return;
        }
        foreach ($serviceConfig as $serviceName => $service) {
            // todo: strict checks
            $this->replaceConfigParameter($service);
            $this->getDi()->set($serviceName, $service->toArray(), (bool)$service->get('shared'));
        }
    }

    /**
     * replace ServiceConstants::TYPE_CONFIG_PARAMETER stubs to its values
     * @param Config $config
     * @throws \Anthill\Phalcon\KernelModule\DependencyInjection\Exceptions\ConfigParseException
     */
    private function replaceConfigParameter(Config $config)
    {
        foreach ($config as $item) {
            if ($item instanceof Config) {
                if (!$item->offsetExists('type')) {
                    $this->replaceConfigParameter($item);
                    continue;
                }
                if ($item->get('type') !== ServiceConstants::TYPE_CONFIG_PARAMETER) {
                    $this->replaceConfigParameter($item);
                    continue;
                }
                $value = $item->get('value');
                $newValue = Stingray::get($this->getConfig(), $value);
                if ($newValue === null) {
                    throw new ConfigParseException(sprintf('You must specify parameter "%s" in config',
                        str_replace('.', ' => ', $value)));
                }
                $item->offsetSet('type', ServiceConstants::TYPE_PARAMETER);
                $item->offsetSet('value', $newValue);
            }
        }
    }

    /**
     * @return DiInterface
     */
    public function getDi()
    {
        return $this->di;
    }

    /**
     * Sets the dependency injector
     *
     * @param mixed $dependencyInjector
     */
    public function setDI(\Phalcon\DiInterface $dependencyInjector)
    {
        $this->di = $dependencyInjector;
    }
}