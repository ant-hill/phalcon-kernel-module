<?php

namespace Tests\Anthill\Phalcon\KernelModule\Module;

use Phalcon\Di;
use Tests\Anthill\Phalcon\KernelModule\DependencyInjection\Fixtures\ServiceInstance;
use Tests\Anthill\Phalcon\KernelModule\Fixtures\TestKernel;
use Tests\Anthill\Phalcon\KernelModule\Module\Fixtures\ModuleFixture;
use Tests\Anthill\Phalcon\KernelModule\Module\Fixtures\ModuleWithoutConfigFixture;
use Tests\Anthill\Phalcon\KernelModule\Module\Fixtures\ModuleWithoutServiceFixture;

class ModuleTest extends \PHPUnit_Framework_TestCase
{
    public function testModuleRegister()
    {
        $di = new Di();
        $kernel = new TestKernel('dev');
        $kernel->setDI($di);
        $kernel->setConfigPath(__DIR__ . '/Fixtures/null_config.php');
        $kernel->boot();
        $moduleA = new ModuleFixture($kernel);
        $moduleA->registerServices($di);
        $moduleA->registerAutoloaders($di);

        $this->assertTrue($di->has('MyTestService'));
        $this->assertInstanceOf(ServiceInstance::class, $di->get('MyTestService'));
        /* @var $instance ServiceInstance */
        $instance = $di->get('MyTestService');
        $this->assertEquals('valueA', $instance->getParamA());
        $this->assertEquals('valueB', $instance->getParamB());
        $this->assertEquals('valueC', $instance->getParamC());
        $this->assertEquals('valueD', $instance->getParamD());
        $this->assertEquals('valueE', $instance->getParamE());
    }

    public function testModuleWithoutConfigRegister()
    {
        $di = new Di();
        $kernel = new TestKernel('dev');
        $kernel->setDI($di);
        $kernel->setConfigPath(__DIR__ . '/Fixtures/config.php');
        $kernel->boot();
        $moduleA = new ModuleWithoutConfigFixture($kernel);
        $moduleA->registerServices($di);
        $moduleA->registerAutoloaders($di);


        $this->assertTrue($di->has('MyTestService'));
        $this->assertInstanceOf(ServiceInstance::class, $di->get('MyTestService'));
        /* @var $instance ServiceInstance */
        $instance = $di->get('MyTestService');
        $this->assertEquals('valueA', $instance->getParamA());
        $this->assertEquals('valueB', $instance->getParamB());
        $this->assertEquals('valueC', $instance->getParamC());
        $this->assertEquals('valueD', $instance->getParamD());
        $this->assertEquals('valueE', $instance->getParamE());
    }

    public function testModuleWithoutServicesRegister()
    {
        $di = new Di();
        $kernel = new TestKernel('dev');
        $kernel->setDI($di);
        $kernel->boot();
        $moduleA = new ModuleWithoutServiceFixture($kernel);
        $moduleA->registerServices($di);
        $moduleA->registerAutoloaders($di);


        $this->assertFalse($di->has('MyTestService'));
    }

    public function testKernelConfigOverwriteModuleConfig()
    {
        $di = new Di();
        $kernel = new TestKernel('dev');
        $kernel->setDI($di);
        $kernel->setConfigPath(__DIR__ . '/Fixtures/configB.php');
        $kernel->boot();
        $moduleA = new ModuleFixture($kernel);
        $moduleA->setConfigPath(__DIR__ . '/Fixtures/configA.php');
        $moduleA->registerServices($di);
        $moduleA->registerAutoloaders($di);

        $this->assertTrue($di->has('MyTestService'));
        $this->assertInstanceOf(ServiceInstance::class, $di->get('MyTestService'));
        /* @var $instance ServiceInstance */
        $instance = $di->get('MyTestService');
        $this->assertEquals('valueA1', $instance->getParamA());
        $this->assertEquals('valueB1', $instance->getParamB());
        $this->assertEquals('valueC1', $instance->getParamC());
        $this->assertEquals('valueD1', $instance->getParamD());
    }

    public function testKernelServicesOverwriteModuleServices()
    {
        $di = new Di();
        $kernel = new TestKernel('dev');
        $kernel->setDI($di);
        $kernel->setConfigPath(__DIR__ . '/Fixtures/config_with_services.php');
        $kernel->setModules(array(
            new ModuleFixture($kernel)
        ));
        $kernel->boot();
        $this->assertTrue($di->has('MyTestService'));
        $this->assertInstanceOf(ServiceInstance::class, $di->get('MyTestService'));
        /* @var $instance ServiceInstance */
        $instance = $di->get('MyTestService');
        $this->assertEquals('valueA2', $instance->getParamA());
        $this->assertEquals('valueB2', $instance->getParamB());
        $this->assertEquals('valueC2', $instance->getParamC());
        $this->assertEquals('valueD2', $instance->getParamD());
        $this->assertEquals('valueE2', $instance->getParamE());
    }

    public function testModuleLoadedViaKernel()
    {
        $di = new Di();
        $kernel = new TestKernel('dev');
        $kernel->setDI($di);
        $kernel->setConfigPath(__DIR__ . '/Fixtures/null_config.php');
        $kernel->setModules(array(new ModuleFixture($kernel)));
        $kernel->boot();
        $this->assertTrue($di->has('MyTestService'));
        $this->assertInstanceOf(ServiceInstance::class, $di->get('MyTestService'));
        /* @var $instance ServiceInstance */
        $instance = $di->get('MyTestService');
        $this->assertEquals('valueA', $instance->getParamA());
        $this->assertEquals('valueB', $instance->getParamB());
        $this->assertEquals('valueC', $instance->getParamC());
        $this->assertEquals('valueD', $instance->getParamD());
        $this->assertEquals('valueE', $instance->getParamE());
    }

}