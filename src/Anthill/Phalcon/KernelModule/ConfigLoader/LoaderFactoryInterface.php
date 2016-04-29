<?php

namespace Anthill\Phalcon\KernelModule\ConfigLoader;


use Anthill\Phalcon\KernelModule\ConfigLoader\Exceptions\LoaderException;
use Phalcon\Config;

interface LoaderFactoryInterface
{
    /**
     * Load config from file extension dynamical
     *
     * @param string $filePath
     * @return Config
     * @throws LoaderException
     */
    public function load($filePath);
}