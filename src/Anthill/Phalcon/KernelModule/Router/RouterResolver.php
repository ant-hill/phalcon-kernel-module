<?php

namespace Anthill\Phalcon\KernelModule\Router;


use Anthill\Phalcon\KernelModule\Router\Loaders\AnnotationRouteLoader;
use Anthill\Phalcon\KernelModule\Router\Loaders\ArrayRouteLoader;
use Phalcon\Mvc\RouterInterface;

class RouterResolver
{
    /**
     * @var array|\Anthill\Phalcon\KernelModule\Router\Loaders\LoaderInterface[]
     */
    private $loaders = array(
        'array' => ArrayRouteLoader::class,
        'annotations' => AnnotationRouteLoader::class,
    );
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * RouterResolver constructor.
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @param $name
     * @param $loader
     * @return $this
     */
    public function addLoaders($name, $loader)
    {
        // todo: checks and exceptions
        $this->loaders[$name] = $loader;
        return $this;
    }


    public function resolve(array $routerConfig)
    {
        foreach ($routerConfig as $config) {
            if (!array_key_exists('type', $config)) {
                // todo : think about
                continue;
            }
            if (!array_key_exists('resource', $config)) {
                // todo : think about
                continue;
            }

            if (!array_key_exists($config['type'], $this->loaders)) {
                // todo : think about
                continue;
            }
            $className = $this->loaders[$config['type']];
            $class = new $className($this->router);
            $class->load($config['resource']);
        }
    }
}


