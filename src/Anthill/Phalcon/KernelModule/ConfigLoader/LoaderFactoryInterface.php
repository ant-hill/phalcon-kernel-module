<?php

namespace Anthill\Phalcon\KernelModule\ConfigLoader;


use Anthill\Phalcon\KernelModule\Loader\Exceptions\LoaderException;
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