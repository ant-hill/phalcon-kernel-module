<?php

namespace Tests\Anthill\Phalcon\KernelModule\DependencyInjection\Fixtures;

class ServiceInstance3
{
    public static $number = 0;

    public function __construct()
    {
        self::$number++;
    }

}