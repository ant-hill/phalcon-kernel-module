<?php
namespace Tests\Anthill\Phalcon\KernelModule\Router\Fixtures;

use Anthill\Phalcon\KernelModule\Router\Loaders\AnnotationRouteLoader;
use Anthill\Phalcon\KernelModule\Router\Loaders\ArrayRouteLoader;
use Phalcon\Di;
use Phalcon\Mvc\Router;

class ArrayRouterTest extends \PHPUnit_Framework_TestCase
{

    public function testAnnotations()
    {
        $di = new Di();
        $di['request'] = new \Phalcon\Http\Request();
        $router = new Router(false);
        $router->setDI($di);
        $loader = new ArrayRouteLoader($router);
        $loader->load(include __DIR__ . '/Fixtures/routes.php');
        $router->handle();
        $this->assertCount(3, $router->getRoutes());

        $routes = [
            [
                'uri' => '/test4',
                'method' => 'GET',
                'controller' => 'test4',
                'action' => 'test4',
            ],
            [
                'uri' => '/test4',
                'method' => 'POST',
                'controller' => 'test4',
                'action' => 'test4',
            ],
            [
                'uri' => '/test5',
                'method' => 'POST',
                'controller' => 'test5',
                'action' => 'test5',
            ],
            [
                'uri' => '/test6',
                'method' => 'GET',
                'controller' => 'test6',
                'action' => 'test6',
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