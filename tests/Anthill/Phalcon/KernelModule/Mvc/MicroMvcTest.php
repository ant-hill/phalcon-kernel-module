<?php

namespace Tests\Anthill\Phalcon\KernelModule\Mvc;


use Anthill\Phalcon\KernelModule\Mvc\Micro as MicroMvc;
use Phalcon\DiInterface;
use Tests\Anthill\Phalcon\KernelModule\Fixtures\TestKernel;

class MicroMvcTest extends \PHPUnit_Framework_TestCase
{
    private $env = 'testEnv';

    public function testAppDiIsInstanceOfDi()
    {
        $kernel = new TestKernel($this->env);
        $app = new MicroMvc($kernel);
        $this->assertInstanceOf(DiInterface::class, $app->getDI());
        return $app;
    }

    /**
     * @depends testAppDiIsInstanceOfDi
     * @param MicroMvc $app
     */
    public function testRoute(MicroMvc $app)
    {
        ob_start();
        $app->handle('/');
        $str = ob_get_clean();
        $this->assertEquals('Hello World!', $str);

        ob_start();
        $app->handle('/asd');
        $str = ob_get_clean();
        $this->assertEquals('Asd', $str);

        ob_start();
        $app->handle('/no-match');
        $str = ob_get_clean();
        $this->assertEquals('Not Found', $str);
    }
}