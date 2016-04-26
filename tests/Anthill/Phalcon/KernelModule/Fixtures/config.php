<?php

return array(
    'application' => array(
        'http' => array(
            'routes' => include __DIR__ . '/route.php'
        )
    ),
    'services' => array(
        'router' => array(
            'className' => \Phalcon\Mvc\Router::class,
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