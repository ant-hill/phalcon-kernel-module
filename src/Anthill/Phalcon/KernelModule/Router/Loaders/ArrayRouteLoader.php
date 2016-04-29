<?php

namespace Anthill\Phalcon\KernelModule\Router\Loaders;

use Phalcon\Config;
use Phalcon\Mvc\Router;

class ArrayRouteLoader implements LoaderInterface
{
    /**
     * @var Router
     */
    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * @param array|Config $config
     */
    public function load($config)
    {
        if (!is_array($config) && !$config instanceof \ArrayAccess) {
            return;
        }

        if (!$config instanceof Config) {
            $config = new Config($config);
        }

        $router = $this->router;
        foreach ($config as $routeName => $route) {
            if (!$route instanceof Config) {
                continue;
            }
            $pattern = $route->get('path', null);
            //     * $router->add('/about', 'About::index', ['GET', 'POST'], Router::POSITION_FIRST);
            $paths = $route->get('handler', null);
            $httpMethods = $route->get('methods', null);

            if ($httpMethods instanceof Config) {
                $httpMethods = $httpMethods->toArray();
            }

            if ($paths instanceof Config) {
                $paths = $paths->toArray();
            }

            $position = $route->get('position', Router::POSITION_LAST);
            $route = $router->add($pattern, $paths, $httpMethods, $position);

            if (is_string($routeName)) {
                $route->setName($routeName);
            }
        }
    }
}