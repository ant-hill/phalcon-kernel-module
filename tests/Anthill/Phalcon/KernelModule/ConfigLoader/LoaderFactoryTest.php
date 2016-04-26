<?php

namespace Tests\Anthill\Phalcon\KernelModule\ConfigLoader;

use Anthill\Phalcon\KernelModule\ConfigLoader\LoaderFactory;
use Phalcon\Config;
use Phalcon\Config\Adapter\Php;

class LoaderFactoryTest extends \PHPUnit_Framework_TestCase
{

    public function testLoadFiles()
    {
        $files = array(
            __DIR__ . '/Fixtures/file1.php',
            __DIR__ . '/Fixtures/file2.json',
            __DIR__ . '/Fixtures/file3.ini',
        );

        if (extension_loaded('yaml')) {
            $files[] = __DIR__ . '/Fixtures/file4.yml';

        }
        foreach ($files as $file) {
            $config = new LoaderFactory();
            $configValues = $config->load($file);
            $this->assertEquals(['a' => 'b'], $configValues->toArray());
        }
    }

    /**
     * @expectedException  \Anthill\Phalcon\KernelModule\ConfigLoader\Exceptions\LoaderException
     */
    public function testLoadNotExistsFile()
    {
        $config = new LoaderFactory();
        $config->load(__DIR__ . '/Fixtures/file100500.php');
    }

    /**
     * @expectedException  \Anthill\Phalcon\KernelModule\ConfigLoader\Exceptions\LoaderException
     */
    public function testLoadNotSupportExtension()
    {
        $config = new LoaderFactory();
        $config->load(__DIR__ . '/Fixtures/file.notsupport');
    }

    public function testAddAdapter()
    {
        $config = new LoaderFactory();
        $config->addAdapters('notsupport', Php::class);
        $configValues = $config->load(__DIR__ . '/Fixtures/file.notsupport');
        $this->assertEquals(['a' => 'b'], $configValues->toArray());
    }

    /**
     * @expectedException  \Anthill\Phalcon\KernelModule\ConfigLoader\Exceptions\LoaderException
     */
    public function testAddAdapterAsObject()
    {
        $config = new LoaderFactory();
        $config->addAdapters('notsupport', new Config([]));
    }

    /**
     * @expectedException  \Anthill\Phalcon\KernelModule\ConfigLoader\Exceptions\LoaderException
     */
    public function testAddAdapterAsNotInstanceOfConfig()
    {
        $config = new LoaderFactory();
        $config->addAdapters('notsupport', new \ArrayObject([]));
    }
}