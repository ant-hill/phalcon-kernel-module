<?php

namespace Tests\Anthill\Phalcon\KernelModule\Router\Fixtures;


use Anthill\Phalcon\KernelModule\Router\RouterResolver;
use Phalcon\Di;

class RouterResolverTest extends \PHPUnit_Framework_TestCase
{

    public function testRouteConfig(){
        $di = new Di();
        $di['request'] = new \Phalcon\Http\Request();
        $di['annotations'] = new \Phalcon\Annotations\Adapter\Memory();
        $router = new \Phalcon\Mvc\Router\Annotations(false);
        $router->setDI($di);

        $resolver = new RouterResolver($router);
        $resolver->resolve(include __DIR__.'/Fixtures/route_config.php');
        $router->handle();

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

        $this->assertCount(count($routes) - 1, $router->getRoutes());

        foreach ($routes as $route) {
            $_SERVER['REQUEST_METHOD'] = $route['method'];
            $router->handle($route['uri']);
            $this->assertEquals($router->getControllerName(), $route['controller']);
            $this->assertEquals($router->getActionName(), $route['action']);
            $this->assertEquals($router->isExactControllerName(), true);
        }

    }
}