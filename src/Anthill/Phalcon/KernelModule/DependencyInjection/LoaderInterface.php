<?php

namespace Anthill\Phalcon\KernelModule\DependencyInjection;


use Phalcon\DiInterface;

interface LoaderInterface
{
    /**
     * load services by path
     * @param $servicePath
     * @return mixed
     */
    public function load($servicePath);

    /**
     * @return DiInterface
     */
    public function getDi();
}