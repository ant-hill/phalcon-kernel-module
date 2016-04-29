<?php

namespace Tests\Anthill\Phalcon\KernelModule;

use Anthill\Phalcon\KernelModule\KernelInterface;
use Phalcon\Config;
use Rwillians\Stingray\Stingray;
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
     * @param KernelInterface $kernel
     * @depends testConfigInstanceOfConfig
     */
    public function testEnvironmentName(KernelInterface $kernel)
    {
        $this->assertEquals($this->env, $kernel->getEnvironment());
    }

    public function testConfig()
    {
        $arr = [
            'a' => [
                'b' => [
                    'c' => [
                        'd' => 'e'
                    ]
                ]
            ],
            'f' => 'h'
        ];

        $config = new \Phalcon\Config($arr);
        $this->assertInstanceOf(\Phalcon\Config::class, Stingray::get($config, 'a'));
        $this->assertEquals($arr['a'], Stingray::get($config, 'a')->toArray());

        $this->assertInstanceOf(\Phalcon\Config::class, Stingray::get($config, 'a.b'));
        $this->assertEquals($arr['a']['b'], Stingray::get($config, 'a.b')->toArray());

        $this->assertInstanceOf(\Phalcon\Config::class, Stingray::get($config, 'a.b.c'));
        $this->assertEquals($arr['a']['b']['c'], Stingray::get($config, 'a.b.c')->toArray());
        $this->assertEquals($arr['a']['b']['c']['d'], Stingray::get($config, 'a.b.c.d'));
        $this->assertEquals($arr['f'], Stingray::get($config, 'f'));

        $this->assertNull(Stingray::get($config, 'a.b.d'));
        $this->assertNull(Stingray::get($config, 'a.b.c.d.e.f.g'));

        $this->assertEquals($arr, $config->toArray());

    }
    public function testConfigMerge()
    {
        $configA = new Config(['paramA' => ['paramB' => 'valueA']]);
        $configB = new Config(['paramA' => ['paramB' => 'valueB', 'paramC' => 'valueC']]);
        $configB->merge($configA);

        $this->assertEquals('valueA',$configB->paramA->paramB);
        $this->assertEquals('valueC',$configB->paramA->paramC);

    }
    
}