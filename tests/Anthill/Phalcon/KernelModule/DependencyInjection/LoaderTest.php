<?php
namespace Tests\Anthill\Phalcon\KernelModule\DependencyInjection;

use Anthill\Phalcon\KernelModule\DependencyInjection\Loader;
use Phalcon\Config;
use Phalcon\Di;
use Tests\Anthill\Phalcon\KernelModule\DependencyInjection\Fixtures\ServiceInstance;

class LoaderTest extends \PHPUnit_Framework_TestCase
{

    public function testServiceCreation()
    {
        $di = new Di();
        $configArray = include __DIR__ . '/Fixtures/config.php';
        $loader = new Loader($di, new Config($configArray));
        $loader->load(__DIR__ . '/Fixtures/services.php');
        $this->assertTrue($di->has('MyTestService'));
        $this->assertInstanceOf(ServiceInstance::class,$di->get('MyTestService'));
        /* @var $instance ServiceInstance */
        $instance = $di->get('MyTestService');
        $this->assertEquals('valueA',$instance->getParamA());
        $this->assertEquals('valueB',$instance->getParamB());
        $this->assertEquals('valueC',$instance->getParamC());
        $this->assertEquals('valueD',$instance->getParamD());
        $this->assertEquals('valueE',$instance->getParamE());

    }
}