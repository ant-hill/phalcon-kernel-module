<?php

namespace Anthill\Phalcon\KernelModule\ConfigLoader;


use Anthill\Phalcon\KernelModule\ConfigLoader\Exceptions\LoaderException;
use Phalcon\Config;
use Phalcon\Config\Adapter\Ini;
use Phalcon\Config\Adapter\Json;
use Phalcon\Config\Adapter\Php;
use Phalcon\Config\Adapter\Yaml;

class LoaderFactory implements LoaderFactoryInterface
{
    private $adapters = array(
        'ini' => Ini::class,
        'json' => Json::class,
        'php' => Php::class,
        'yml' => Yaml::class,
    );

    /**
     * @param $extension
     * @param $configHandler
     * @throws LoaderException
     */
    public function addAdapters($extension, $configHandler)
    {
        if (!is_string($configHandler)) {
            throw new LoaderException(
                sprintf(
                    '$configHandler must be a string represented class which is an instanceof %s',
                    Config::class)
            );
        }

        if (!is_subclass_of($configHandler, Config::class, true)) {
            throw new LoaderException(sprintf('$configHandler must be instanceof %s', Config::class));
        }

        $this->adapters[$extension] = $configHandler;
    }


    /**
     * Load config from file extension dynamical
     *
     * @param string $filePath
     * @return Config
     * @throws LoaderException
     */
    public function load($filePath)
    {
        if (!is_file($filePath)) {
            throw new LoaderException('Config file not found');
        }

        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        if (!array_key_exists($extension, $this->adapters)) {
            throw new LoaderException('Config adapter for .' . $extension . ' files is not support');
        }

        $loader = $this->adapters[$extension];

        return new $loader($filePath);
    }
}