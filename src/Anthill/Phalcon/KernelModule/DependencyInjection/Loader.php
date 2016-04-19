<?php

namespace Anthill\Phalcon\KernelModule\DependencyInjection;


use Phalcon\Config;
use Phalcon\DiInterface;
use Rwillians\Stingray\Stingray;

class Loader implements LoaderInterface
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
     * Loader constructor.
     * @param DiInterface $di
     * @param Config $config
     */
    public function __construct(DiInterface $di, Config $config)
    {
        $this->di = $di;
        $this->config = $config;
    }


    /**
     * {@inheritdoc}
     */
    public function load($serviceConfig)
    {
        if(!$serviceConfig instanceof Config){
            return;
        }
        foreach ($serviceConfig as $serviceName => $service) {
            // todo: strict checks
            $this->replaceConfigParameter($service);
            $this->getDi()->set($serviceName, $service->toArray(),(bool) $service->get('shared'));
        }
    }

    public function loadByPath($servicePath)
    {
        if (!file_exists($servicePath)) {
            return;
        }
        /* @var $serviceConfig Config */
        $serviceConfig = Config\Loader::load($servicePath);
        $this->load($serviceConfig);
    }

    /**
     * replace ServiceConstants::TYPE_CONFIG_PARAMETER stubs to its values
     * @param Config $config
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
                $newValue = Stingray::get($this->config, $value);
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
}