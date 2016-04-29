<?php

namespace Anthill\Phalcon\KernelModule\Router\Loaders;


interface LoaderInterface
{
    public function load($resource);
}