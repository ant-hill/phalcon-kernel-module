<?php

namespace Anthill\Phalcon\KernelModule\Cli;

use Anthill\Phalcon\KernelModule\KernelInterface;
use Phalcon\Di\InjectionAwareInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Application
 * @package Anthill\Phalcon\KernelModule\Cli
 */
class Application extends \Symfony\Component\Console\Application implements InjectionAwareInterface
{
    /**
     * @var KernelInterface
     */
    private $kernel;

    /**
     * Application constructor.
     * @param KernelInterface $kernel
     * @throws \Symfony\Component\Console\Exception\LogicException
     * @throws \Symfony\Component\Console\Exception\InvalidArgumentException
     */
    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
        parent::__construct($kernel->getName() . ' cli application');
        //todo: move to ./bin/console
        $this->getDefinition()->addOption(new InputOption('--env', '-e', InputOption::VALUE_REQUIRED,
            'The Environment name.', $kernel->getEnvironment()));
    }

    /**
     * Runs the current application.
     *
     * @param InputInterface $input An Input instance
     * @param OutputInterface $output An Output instance
     *
     * @return int 0 if everything went fine, or an error code
     */
    public function doRun(InputInterface $input, OutputInterface $output)
    {
        $this->kernel->boot();
        $this->setDI($this->kernel->getDI());
        return parent::doRun($input, $output);
    }

    /**
     * @var \Phalcon\DiInterface
     */
    private $dependencyInjector;

    /**
     * Sets the dependency injector
     *
     * @param mixed $dependencyInjector
     */
    public function setDI(\Phalcon\DiInterface $dependencyInjector)
    {
        $this->dependencyInjector = $dependencyInjector;
    }

    /**
     * Returns the internal dependency injector
     *
     * @return \Phalcon\DiInterface
     */
    public function getDI()
    {
        return $this->dependencyInjector;
    }
}