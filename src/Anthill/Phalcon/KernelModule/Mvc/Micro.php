<?php

namespace Anthill\Phalcon\KernelModule\Mvc;


use Anthill\Phalcon\KernelModule\KernelInterface;

class Micro extends \Phalcon\Mvc\Micro
{
    /**
     * @var KernelInterface
     */
    private $kernel;

    /**
     * @var \Phalcon\Config
     */
    private $configuration;

    /**
     * Phalcon\Mvc\Micro constructor
     *
     * @param KernelInterface $kernel
     */
    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
        $kernel->boot();
        $this->configuration = $this->kernel->getConfig();
        parent::__construct($kernel->getDI());
        $routeDir = $this->configuration->get('application')->get('route');
        $this->addRoutesByPath($routeDir);
    }

    public function addRoutesByPath($path)
    {
        $app = $this;
        include_once $path;
    }
}