<?php

return [
    'router' => [
        'routes' => [
            'ZfMetal\\Calendar' => [
                'mayTerminate' => false,
                'options' => [
                    'route' => '/zfmc',
                ],
                'type' => 'Literal',
                'child_routes' => [
                    'Calendar' => [
                        'mayTerminate' => false,
                        'options' => [
                            'defaults' => [
                                'controller' => \ZfMetal\Calendar\Controller\CalendarController::CLASS,
                                'action' => 'grid',
                            ],
                            'route' => '/calendar',
                        ],
                        'type' => 'Literal',
                        'child_routes' => [
                            'Grid' => [
                                'mayTerminate' => true,
                                'options' => [
                                    'defaults' => [
                                        'controller' => \ZfMetal\Calendar\Controller\CalendarController::CLASS,
                                        'action' => 'grid',
                                    ],
                                    'route' => '/grid',
                                ],
                                'type' => 'Segment',
                            ],
                        ],
                    ],
                    'ManagerCalendar' => [
                        'mayTerminate' => false,
                        'options' => [
                            'defaults' => [
                                'controller' => \ZfMetal\Calendar\Controller\ManagerCalendarController::CLASS,
                                'action' => 'list',
                            ],
                            'route' => '/manager-calendar',
                        ],
                        'type' => 'Literal',
                        'child_routes' => [
                            'List' => [
                                'mayTerminate' => true,
                                'options' => [
                                    'defaults' => [
                                        'controller' => \ZfMetal\Calendar\Controller\ManagerCalendarController::CLASS,
                                        'action' => 'list',
                                    ],
                                    'route' => '/list',
                                ],
                                'type' => 'Segment',
                            ],
                            'Manage' => [
                                'mayTerminate' => true,
                                'options' => [
                                    'defaults' => [
                                        'controller' => \ZfMetal\Calendar\Controller\ManagerCalendarController::CLASS,
                                        'action' => 'manage',
                                    ],
                                    'route' => '/manage[/:id]',
                                ],
                                'type' => 'Segment',
                            ],
                        ],
                    ],
                    'Holiday' => [
                        'mayTerminate' => false,
                        'options' => [
                            'defaults' => [
                                'controller' => \ZfMetal\Calendar\Controller\HolidayController::CLASS,
                                'action' => 'grid',
                            ],
                            'route' => '/holiday',
                        ],
                        'type' => 'Literal',
                        'child_routes' => [
                            'Grid' => [
                                'mayTerminate' => true,
                                'options' => [
                                    'defaults' => [
                                        'controller' => \ZfMetal\Calendar\Controller\HolidayController::CLASS,
                                        'action' => 'grid',
                                    ],
                                    'route' => '/grid',
                                ],
                                'type' => 'Segment',
                            ],
                        ],
                    ],
                    'api' => [
                        'type' => 'Literal',
                        'mayTerminate' => false,
                        'options' => [
                            'route' => '/api',
                        ],
                        'child_routes' => [
                            'ticket' => [
                                'type' => 'Segment',
                                'mayTerminate' => false,
                                'options' => [
                                    'route' => '/tickets[/:id]',
                                    'defaults' => [
                                        'controller' => 'ZfMetal\\Calendar\\Controller\\ApiTicketController',
                                    ],
                                ],
                            ],
                            'entity' => [
                                'type' => 'Segment',
                                'mayTerminate' => false,
                                'options' => [
                                    'route' => '/:entityAlias[/:id]',
                                    'defaults' => [
                                        'controller' => 'ZfMetal\\Restful\\Controller\\MainController',
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'Home' => [
                        'mayTerminate' => true,
                        'options' => [
                            'route' => '/home',
                            'defaults' => [
                                'controller' => \ZfMetal\Calendar\Controller\HomeController::CLASS,
                                'action' => 'index',
                            ],
                        ],
                        'type' => 'Literal',
                    ],
                    'EventSchedule' => [
                        'mayTerminate' => false,
                        'options' => [
                            'route' => '/event-schedule',
                            'defaults' => [
                                'controller' => \ZfMetal\Calendar\Controller\EventScheduleController::CLASS,
                                'action' => 'schedule',
                            ],
                        ],
                        'type' => 'Literal',
                        'child_routes' => [
                            'Schedule' => [
                                'mayTerminate' => true,
                                'options' => [
                                    'route' => '/schedule',
                                    'defaults' => [
                                        'controller' => \ZfMetal\Calendar\Controller\EventScheduleController::CLASS,
                                        'action' => 'schedule',
                                    ],
                                ],
                                'type' => 'Segment',
                            ],
                        ],
                    ],
                    'Event' => [
                        'mayTerminate' => false,
                        'options' => [
                            'route' => '/event',
                            'defaults' => [
                                'controller' => \ZfMetal\Calendar\Controller\EventController::CLASS,
                                'action' => 'grid',
                            ],
                        ],
                        'type' => 'Literal',
                        'child_routes' => [
                            'Grid' => [
                                'mayTerminate' => true,
                                'options' => [
                                    'route' => '/grid',
                                    'defaults' => [
                                        'controller' => \ZfMetal\Calendar\Controller\EventController::CLASS,
                                        'action' => 'grid',
                                    ],
                                ],
                                'type' => 'Segment',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];