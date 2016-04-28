<?php
use Anthill\Phalcon\KernelModule\DependencyInjection\ServiceConstants as Service;
use Tests\Anthill\Phalcon\KernelModule\DependencyInjection\Fixtures\ServiceInstance;
use Tests\Anthill\Phalcon\KernelModule\DependencyInjection\Fixtures\ServiceInstance2;
use Tests\Anthill\Phalcon\KernelModule\DependencyInjection\Fixtures\ServiceInstance3;
use Tests\Anthill\Phalcon\KernelModule\DependencyInjection\Fixtures\ServiceInstance4;

return [
    'services' => [
        'MyTestService' => [
            Service::CLASS_NAME => ServiceInstance::class,
            Service::ARGUMENTS => [
                [
                    Service::TYPE => Service::TYPE_PARAMETER,
                    Service::VALUE => 'valueA2',
                ],
                [
                    Service::TYPE => Service::TYPE_PARAMETER,
                    Service::VALUE => 'valueB2'
                ]
            ],
            Service::CALLS => [
                [
                    Service::CALLS_METHOD => 'setC',
                    Service::ARGUMENTS => [
                        [
                            Service::TYPE => Service::TYPE_PARAMETER,
                            Service::VALUE => 'valueC2',
                        ]
                    ]
                ]
            ],
            Service::PROPERTIES => [
                [
                    Service::PROPERTY_NAME => 'paramD',
                    Service::VALUE => [
                        Service::TYPE => Service::TYPE_PARAMETER,
                        Service::VALUE => 'valueD2',
                    ]
                ],
                [
                    Service::PROPERTY_NAME => 'paramE',
                    Service::VALUE => [
                        Service::TYPE => Service::TYPE_PARAMETER,
                        Service::VALUE => 'valueE2',
                    ]
                ]
            ],
            'shared' => true
        ],
        'MyTestService2' => [
            Service::CLASS_NAME => ServiceInstance2::class,
            'shared' => false
        ],
        'MyTestService3' => [
            Service::CLASS_NAME => ServiceInstance3::class,
            'shared' => true
        ],
        'MyTestService4' => array(
            Service::CLASS_NAME => ServiceInstance4::class
        )
    ]
];