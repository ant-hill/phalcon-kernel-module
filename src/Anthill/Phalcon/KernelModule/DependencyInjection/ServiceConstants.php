<?php

namespace Anthill\Phalcon\KernelModule\DependencyInjection;


use Phalcon\Config;
use Phalcon\DiInterface;

class ServiceConstants
{
    /**
     * Ex:
     *   'className'  => 'SomeApp\SomeComponent',
     */
    const CLASS_NAME = 'className';

    /**
     * Ex:
     *  array(
     *   'name'  => 'someFlag',
     *   'value' => array(
     *       'type'  => 'parameter',
     *       'value' => true
     *       )
     *  )
     *
     */
    const PROPERTIES = 'properties';
    /**
     * @see ServiceConstants::PROPERTIES
     */
    const PROPERTY_NAME = 'name';

    /**
     * Ex:
     *  'calls'     => array(
     *       array(
    '*           method'    => 'setResponse',
     */
    const CALLS = 'calls';

    /**
     * Ex:
     * array(
     *     'className' => 'SomeApp\SomeComponent',
     *     'calls'     => array(
     *            array(
     *               'method'    => 'setResponse',
     *               'arguments' => array(
     *                    array(
     *                       'type' => 'service',
     *                       'name' => 'response'
     *                    )
     *                )
     *           ),
     *     )
     * )
     */
    const CALLS_METHOD = 'method';

    /**
     * Parameter for constructor arguments
     * Ex:
     *
     * 'className' => 'SomeApp\SomeComponent',
     *     'arguments' => array(
     *         array('type' => 'service', 'name' => 'response'),
     *         array('type' => 'parameter', 'value' => true)
     *     )
     */
    const ARGUMENTS = 'arguments';

    /**
     * Ex:
     *  array('type' => 'config_parameter', 'value' => 'some.config.value')
     */
    const TYPE = 'type';

    /**
     * Ex:
     *  array('type' => 'config_parameter', 'value' => 'some.config.value')
     */
    const VALUE = 'value';

    /**
     * Represents a literal value to be passed as parameter which get from config
     *  Ex:
     *  array('type' => 'config_parameter', 'value' => 'some.config.value') // $config->some->config->value
     */
    const TYPE_CONFIG_PARAMETER = 'config_parameter';

    /**
     *  Represents a literal value to be passed as parameter
     *  Ex:
     *  array('type' => 'parameter', 'value' => 1234)
     */
    const TYPE_PARAMETER = 'parameter';

    /**
     * Represents another service in the service container
     * Ex:
     * array('type' => 'service', 'name' => 'request')
     */
    const TYPE_SERVICE = 'service';

    /**
     * Represents an object that must be built dynamically
     * Ex:
     * array('type' => 'instance', 'className' => 'DateTime', 'arguments' => array('now'))
     */
    const TYPE_INSTANCE = 'instance';

}