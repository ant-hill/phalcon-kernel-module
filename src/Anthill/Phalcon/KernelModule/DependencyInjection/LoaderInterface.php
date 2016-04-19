<?php

namespace Anthill\Phalcon\KernelModule\DependencyInjection;


use Phalcon\Config;
use Phalcon\DiInterface;

interface LoaderInterface
{
    /**
     * load services by path
     * @param Config $serviceConfig
     * @return mixed
     */
    public function load($serviceConfig);

    /**
     * @return DiInterface
     */
    public function getDi();
}