<?php

namespace Tests\Anthill\Phalcon\KernelModule;

use Anthill\Phalcon\KernelModule\KernelInterface;
use Phalcon\Config;
use Tests\Anthill\Phalcon\KernelModule\Fixtures\TestKernel;

class KernelTest extends \PHPUnit_Framework_TestCase
{

    private $env = 'envName';

    public function testConfigInstanceOfConfig()
    {
        $kernel = new TestKernel($this->env);
        $kernel->boot();
        $this->assertInstanceOf(Config::class, $kernel->getConfig());
        return $kernel;
    }

    /**
     * @depends testConfigInstanceOfConfig
     */
    public function testConfigIsRight(KernelInterface $kernel)
    {
        $config = $kernel->getConfig();
        $this->assertEquals(array('application' => array('route' => realpath(__DIR__ . '/Fixtures/route.php'))),
            $config->toArray()
        );
        return $kernel;
    }

    /**
     * @param KernelInterface $kernel
     * @depends testConfigIsRight
     */
    public function testEnvironmentName(KernelInterface $kernel)
    {
        $this->assertEquals($this->env, $kernel->getEnvironment());
    }
}