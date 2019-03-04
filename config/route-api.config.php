<?php

return [
    'router' => [
        'routes' => [
            'ZfMetalCalendar' => [
                'mayTerminate' => false,
                'options' => [
                    'route' => '/zfmc',
                ],
                'type' => \Zend\Router\Http\Literal::class,
                'child_routes' => [
                    'Api' => [
                        'type' => \Zend\Router\Http\Literal::class,
                        'mayTerminate' => false,
                        'options' => [
                            'route' => '/api',
                        ],
                        'child_routes' => [
                            'calendars' => [
                                'type' => \Zend\Router\Http\Segment::class,
                                'mayTerminate' => false,
                                'options' => [
                                    'route' => '/calendars[/:id]',
                                    'defaults' => [
                                        'controller' => \ZfMetal\Calendar\Controller\CalendarApiController::class,
                                    ],
                                ],
                            ],
                            'entity' => [
                                'type' => \Zend\Router\Http\Segment::class,
                                'mayTerminate' => false,
                                'options' => [
                                    'route' => '/:entityAlias[/:id]',
                                    'defaults' => [
                                        'controller' => \ZfMetal\Restful\Controller\MainController::class,
                                    ],
                                ],
                            ],
                            'start' => [
                                'type' => \Zend\Router\Http\Segment::class,
                                'mayTerminate' => false,
                                'options' => [
                                    'route' => '/start',
                                    'defaults' => [
                                        'controller' => 'ZfMetal\\Calendar\\Controller\\ApiStartController',
                                    ],
                                ],
                            ],
                            'Appointments' => [
                                'mayTerminate' => false,
                                'options' => [
                                    'route' => '/appointments',
                                ],
                                'type' => \Zend\Router\Http\Literal::class,
                                'child_routes' => [
                                    'AvailableShifts' => [
                                        'mayTerminate' => true,
                                        'options' => [
                                            'route' => '/availables/:calendarId/:date',
                                            'defaults' => [
                                                'controller' => \ZfMetal\Calendar\Controller\ShiftController::CLASS,
                                                'action' => 'availableShifts',
                                            ],
                                        ],
                                        'type' => \Zend\Router\Http\Segment::class,
                                    ],
                                    'MyAppointments' => [
                                        'mayTerminate' => true,
                                        'options' => [
                                            'route' => '/my-appointments',
                                            'defaults' => [
                                                'controller' => \ZfMetal\Calendar\Controller\AppointmentApiController::CLASS,
                                                'action' => 'myAppointments',
                                            ],
                                        ],
                                        'type' => \Zend\Router\Http\Literal::class,
                                    ],
                                    'TakeAppointment' => [
                                        'mayTerminate' => true,
                                        'options' => [
                                            'route' => '/take',
                                            'defaults' => [
                                                'controller' => \ZfMetal\Calendar\Controller\AppointmentApiController::CLASS,
                                                'action' => 'create',
                                            ],
                                        ],
                                        'type' => \Zend\Router\Http\Segment::class,
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];