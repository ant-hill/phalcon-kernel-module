<?php

namespace Tests\Anthill\Phalcon\KernelModule\Http;

use Anthill\Phalcon\KernelModule\Http\Application;
use Phalcon\Mvc\Router;
use Tests\Anthill\Phalcon\KernelModule\Fixtures\TestKernel;

class ApplicationTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateApplication()
    {
        $appKernel = new TestKernel('dev');
        $application = new Application($appKernel);
        $response = $application->handle('/about');
        $this->assertEquals('asd', $response->getContent());
    }

    /**
     * @expectedException \Phalcon\Mvc\Dispatcher\Exception
     */
    public function testApplicationWithNotFoundRoute()
    {
        $appKernel = new TestKernel('dev');
        $application = new Application($appKernel);
        ob_end_clean(); // application don't close output buffer after exception
        $application->handle('/asdasd111');
    }
}