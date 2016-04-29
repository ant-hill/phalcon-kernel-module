<?php

namespace Tests\Anthill\Phalcon\KernelModule\Http;

use Phalcon\Di;
use Phalcon\Loader;
use Phalcon\Mvc\Application;
use Phalcon\Mvc\Router;
use Tests\Anthill\Phalcon\KernelModule\Fixtures\TestKernel;

class ApplicationTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateApplication()
    {
        $appKernel = new TestKernel('dev');
        $appKernel->boot();
        $appKernel->registerRoutes();
        $application = new Application($appKernel->getDI());
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $response = $application->handle('/about');
        $this->assertEquals('asd', $response->getContent());
    }

    /**
     * @expectedException \Phalcon\Mvc\Dispatcher\Exception
     */
    public function testApplicationWithNotFoundRoute()
    {
        $appKernel = new TestKernel('dev');
        $appKernel->boot();
        $application = new Application($appKernel->getDI());
        ob_end_clean(); // application don't close output buffer after exception
        $application->handle('/asdasd111');
    }

}