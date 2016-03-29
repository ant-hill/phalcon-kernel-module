<?php

namespace Tests\Anthill\Phalcon\KernelModule\Cli;

use Anthill\Phalcon\KernelModule\Cli\Application;
use Phalcon\DiInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\NullOutput;
use Tests\Anthill\Phalcon\KernelModule\Fixtures\TestKernel;

class ApplicationTest extends \PHPUnit_Framework_TestCase
{

    private $env = 'testEnv';

    public function testAppDiIsInstanceOfDi()
    {
        $kernel = new TestKernel($this->env);
        $app = new \Anthill\Phalcon\KernelModule\Cli\Application($kernel);
        $app->doRun(new ArgvInput(), new NullOutput());
        $app->setAutoExit(false);
        $this->assertInstanceOf(DiInterface::class, $app->getDI());
        return $app;
    }

    /**
     * @depends testAppDiIsInstanceOfDi
     */
    public function testApplicationCallCommandByName(Application $app)
    {
        $input = new StringInput('SomeCommandName');
        $mockObj = $this->getMock(Command::class, array('execute'), array('SomeCommandName'));
        $mockObj->expects($this->once())->method('execute');
        $app->add($mockObj);
        $returnCode = $app->run($input, new NullOutput());
        $this->assertEquals(0, $returnCode);
    }
}