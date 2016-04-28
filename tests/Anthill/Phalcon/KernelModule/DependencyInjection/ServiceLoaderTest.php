<?php
namespace Tests\Anthill\Phalcon\KernelModule\DependencyInjection;

use Anthill\Phalcon\KernelModule\DependencyInjection\ServiceLoader;
use Phalcon\Config;
use Phalcon\Di;
use Phalcon\DiInterface;
use Tests\Anthill\Phalcon\KernelModule\DependencyInjection\Fixtures\ServiceInstance;
use Tests\Anthill\Phalcon\KernelModule\Fixtures\TestKernel;

class ServiceLoaderTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @param DiInterface $di
     * @return ServiceLoader
     */
    private function getServiceLoader(DiInterface $di){
        $kernel = new TestKernel('ololo');
        $kernel->setDI($di);
        $kernel->setConfigPath(__DIR__.'/Fixtures/config.php');
        $kernel->boot();

        return new ServiceLoader($kernel);
    }

    public function testServiceCreation()
    {
        $di = new Di();
        $loader = $this->getServiceLoader($di);
        $loader->load(new Config(include __DIR__ . '/Fixtures/services.php'));

        $this->assertTrue($di->has('MyTestService'));
        $this->assertInstanceOf(ServiceInstance::class, $di->get('MyTestService'));
        /* @var $instance ServiceInstance */
        $instance = $di->get('MyTestService');
        $this->assertEquals('valueA', $instance->getParamA());
        $this->assertEquals('valueB', $instance->getParamB());
        $this->assertEquals('valueC', $instance->getParamC());
        $this->assertEquals('valueD', $instance->getParamD());
        $this->assertEquals('valueE', $instance->getParamE());
        $this->assertEquals(1, $instance::$number);
    }
    
    public function testSharedParam(){
        $di = new Di();
        $loader = $this->getServiceLoader($di);
        $loader->load(new Config(include __DIR__ . '/Fixtures/services.php'));

        $di->get('MyTestService3');
        $di->get('MyTestService3');
        $di->get('MyTestService3');
        $di->get('MyTestService3');
        /* @var $instance ServiceInstance */
        $instance = $di->get('MyTestService3');
        $this->assertEquals(1, $instance::$number);
    }

    public function testNoSharedParam(){
        $di = new Di();
        $loader = $this->getServiceLoader($di);
        $loader->load(new Config(include __DIR__ . '/Fixtures/services.php'));

        $di->get('MyTestService2');
        $di->get('MyTestService2');
        $di->get('MyTestService2');
        $di->get('MyTestService2');
        /* @var $instance ServiceInstance */
        $instance = $di->get('MyTestService2');
        $this->assertEquals(5, $instance::$number);
    }

    public function testDefaultNoSharedParam(){
        $di = new Di();
        $loader = $this->getServiceLoader($di);
        $loader->load(new Config(include __DIR__ . '/Fixtures/services.php'));

        $di->get('MyTestService4');
        $di->get('MyTestService4');
        $di->get('MyTestService4');
        $di->get('MyTestService4');
        /* @var $instance ServiceInstance */
        $instance = $di->get('MyTestService4');
        $this->assertEquals(5, $instance::$number);
    }
}