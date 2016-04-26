<?php

namespace Anthill\Phalcon\KernelModule\Http;


use Anthill\Phalcon\KernelModule\KernelInterface;
use Phalcon\Config;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Router;
use Rwillians\Stingray\Stingray;

class Application extends \Phalcon\Mvc\Application
{
    /**
     * @var KernelInterface
     */
    private $kernel;

    /**
     * Application constructor.
     * @param KernelInterface $kernel
     */
    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
        $this->kernel->boot();
        parent::__construct($kernel->getDI());
        $this->boot();
    }

    private function boot()
    {
        /* @var $router Router */
        $router = $this->getDI()->get('router');
        $routes = Stingray::get($this->kernel->getConfig(), 'application.http.routes');
        if (!$routes) {
            return;
        }
        foreach ($routes as $routeName => $route) {
            if (!$route instanceof Config) {
                continue;
            }
            $pattern = $route->get('path', null);
            //     * $router->add('/about', 'About::index', ['GET', 'POST'], Router::POSITION_FIRST);
            $paths = $route->get('handler', null);
            $httpMethods = $route->get('httpMethods', null);
            $position = $route->get('position', Router::POSITION_LAST);
            $router->add($pattern, $paths, $httpMethods, $position)->setName($routeName);
        }
    }
}