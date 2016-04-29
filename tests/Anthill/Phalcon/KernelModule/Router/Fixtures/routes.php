<?php
return array(
    array(
        'path' => '/test4',
        'methods' => array('GET', 'POST'),
        'handler' => '\\Tests\\Anthill\\Phalcon\\KernelModule\\Router\\Fixtures\\Test4::test4'
    ),
    'test2' => array(
        'path' => '/test5',
        'methods' => 'POST',
        'handler' => '\\Tests\\Anthill\\Phalcon\\KernelModule\\Router\\Fixtures\\Test5::test5'
    ),
    array(
        'path' => '/test6',
        'methods' => 'GET',
        'handler' => array(
            'namespace' => "\\Tests\\Anthill\\Phalcon\\KernelModule\\Router\\Fixtures",
            'controller' => 'test6',
            'action' => 'test6'
        )
    ),
);