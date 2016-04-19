<?php

use Anthill\Phalcon\KernelModule\DependencyInjection\ServiceConstants as Service;
use Tests\Anthill\Phalcon\KernelModule\DependencyInjection\Fixtures\ServiceInstance;

return [
    'MyTestService' => [
        Service::CLASS_NAME => ServiceInstance::class,
        Service::ARGUMENTS => [
            [
                Service::TYPE => Service::TYPE_CONFIG_PARAMETER,
                Service::VALUE => 'di.fixtures.paramA',
            ],
            [
                Service::TYPE => Service::TYPE_CONFIG_PARAMETER,
                Service::VALUE => 'di.fixtures.paramB'
            ]
        ],
        Service::CALLS => [
            [
                Service::CALLS_METHOD => 'setC',
                Service::ARGUMENTS => [
                    [
                        Service::TYPE => Service::TYPE_CONFIG_PARAMETER,
                        Service::VALUE => 'di.fixtures.paramC',
                    ]
                ]
            ]
        ],
        Service::PROPERTIES => [
            [
                Service::PROPERTY_NAME => 'paramD',
                Service::VALUE => [
                    Service::TYPE => Service::TYPE_CONFIG_PARAMETER,
                    Service::VALUE => 'di.fixtures.paramD',
                ]
            ],
            [
                Service::PROPERTY_NAME => 'paramE',
                Service::VALUE => [
                    Service::TYPE => Service::TYPE_PARAMETER,
                    Service::VALUE => 'valueE',
                ]
            ]
        ]
    ]
];