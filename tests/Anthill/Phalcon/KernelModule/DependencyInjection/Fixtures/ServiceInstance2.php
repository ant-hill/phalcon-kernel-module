<?php

namespace Tests\Anthill\Phalcon\KernelModule\DependencyInjection\Fixtures;

class ServiceInstance2
{
    public static $number = 0;
    public function __construct()
    {
        self::$number++;
    }
}