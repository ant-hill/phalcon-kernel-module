<?php

return array(
    'framework' => array(
        'routes' => array(
            array(
                'type' => 'array',
                'resource' => include __DIR__ . '/route.php'
            )
        )
    ),
    'services' => array(
        'router' => array(
            'className' => \Phalcon\Mvc\Router\Annotations::class,
            'arguments' => array(
                array(
                    'type' => 'parameter',
                    'value' => false
                )
            ),
            'shared' => true
        ),
        'view' => array(
            'className' => \Phalcon\Mvc\View::class,
            'shared' => true
        ),
        'route_resolver' => array(
            'className' => \Anthill\Phalcon\KernelModule\Router\RouterResolver::class,
            'arguments' => array(
                array(
                    'type' => 'service',
                    'name' => 'router'
                )
            ),
            'shared' => true
        ),

        'dispatcher' => array(
            'className' => \Phalcon\Mvc\Dispatcher::class,
            'calls' => array(
                array(
                    'method' => 'setEventsManager',
                    'arguments' => array(
                        array(
                            'type' => 'service',
                            'name' => 'eventsManager'
                        )
                    )
                )
            ),
            'shared' => true
        ),
        'eventsManager' => array(
            'className' => \Phalcon\Events\Manager::class,
            'shared' => true
        ),
        'response' => array(
            'className' => \Phalcon\Http\Response::class,
            'shared' => true
        ),
        'request' => array(
            'className' => \Phalcon\Http\Request::class,
            'shared' => true
        )
    )
);