<?php
namespace Tests\Anthill\Phalcon\KernelModule\Router\Fixtures;

use Anthill\Phalcon\KernelModule\Router\Loaders\AnnotationRouteLoader;
use Phalcon\Di;

class AnnotationsRouterTest extends \PHPUnit_Framework_TestCase
{

    public function testAnnotations()
    {
        $di = new Di();
        $di['request'] = new \Phalcon\Http\Request();
        $di['annotations'] = new \Phalcon\Annotations\Adapter\Memory();
        $router = new \Phalcon\Mvc\Router\Annotations(false);
        $router->setDI($di);
        $loader = new AnnotationRouteLoader($router);
        $loader->load(__DIR__ . '/Fixtures');
        $router->handle();
        $this->assertCount(3, $router->getRoutes());

        $routes = [
            [
                'uri' => '/test1',
                'method' => 'GET',
                'controller' => 'test1',
                'action' => 'test1',
            ],
            [
                'uri' => '/test2',
                'method' => 'POST',
                'controller' => 'test2',
                'action' => 'test2',
            ],
            [
                'uri' => '/test3',
                'method' => 'GET',
                'controller' => 'test3',
                'action' => 'test3',
            ],
        ];

        foreach ($routes as $route) {
            $_SERVER['REQUEST_METHOD'] = $route['method'];
            $router->handle($route['uri']);
            $this->assertEquals($router->getControllerName(), $route['controller']);
            $this->assertEquals($router->getActionName(), $route['action']);
            $this->assertEquals($router->isExactControllerName(), true);
        }
    }
}