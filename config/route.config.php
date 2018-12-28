<?php

return [
    'router' => [
        'routes' => [
            'ZfMetalCalendar' => [
                'mayTerminate' => false,
                'options' => [
                    'route' => '/zfmc',
                ],
                'type' => 'Literal',
                'child_routes' => [
                    'ServiceSearch' => [
                        'type' => 'Literal',
                        'mayTerminate' => true,
                        'options' => [
                            'defaults' => [
                                'controller' => \ZfMetal\Calendar\Controller\ServiceSearchController::CLASS,
                                'action' => 'search',
                            ],
                            'route' => '/serviceSearch',
                        ],
                        ],
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
                    'Api' => [
                        'type' => 'Literal',
                        'mayTerminate' => false,
                        'options' => [
                            'route' => '/api',
                        ],
                        'child_routes' => [
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
                            'start' => [
                                'type' => 'Segment',
                                'mayTerminate' => false,
                                'options' => [
                                    'route' => '/start',
                                    'defaults' => [
                                        'controller' => 'ZfMetal\\Calendar\\Controller\\ApiStartController',
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
                    'EventState' => [
                        'mayTerminate' => false,
                        'options' => [
                            'route' => '/event-state',
                            'defaults' => [
                                'controller' => \ZfMetal\Calendar\Controller\EventStateController::CLASS,
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
                                        'controller' => \ZfMetal\Calendar\Controller\EventStateController::CLASS,
                                        'action' => 'grid',
                                    ],
                                ],
                                'type' => 'Segment',
                            ],
                        ],
                    ],
                    'EventType' => [
                        'mayTerminate' => false,
                        'options' => [
                            'route' => '/event-type',
                            'defaults' => [
                                'controller' => \ZfMetal\Calendar\Controller\EventTypeController::CLASS,
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
                                        'controller' => \ZfMetal\Calendar\Controller\EventTypeController::CLASS,
                                        'action' => 'grid',
                                    ],
                                ],
                                'type' => 'Segment',
                            ],
                        ],
                    ],
                    'OutOfService' => [
                        'mayTerminate' => false,
                        'options' => [
                            'route' => '/out-of-service',
                            'defaults' => [
                                'controller' => \ZfMetal\Calendar\Controller\OutOfServiceController::CLASS,
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
                                        'controller' => \ZfMetal\Calendar\Controller\OutOfServiceController::CLASS,
                                        'action' => 'grid',
                                    ],
                                ],
                                'type' => 'Segment',
                            ],
                        ],
                    ],
                    'CalendarGroup' => [
                        'mayTerminate' => false,
                        'options' => [
                            'route' => '/calendar-group',
                            'defaults' => [
                                'controller' => 'ZfMetal\\Calendar\\Controller\\CalendarGroupController',
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
                                        'controller' => 'ZfMetal\\Calendar\\Controller\\CalendarGroupController',
                                        'action' => 'grid',
                                    ],
                                ],
                                'type' => 'Segment',
                            ],
                        ],
                    ],
                    'api' => [
                        'mayTerminate' => false,
                        'options' => [
                            'route' => '/api',
                        ],
                        'type' => 'Literal',
                    ],
                    'Export' => [
                        'mayTerminate' => false,
                        'options' => [
                            'route' => '/export',
                            'defaults' => [
                                'controller' => \ZfMetal\Calendar\Controller\ExportController::CLASS,
                                'action' => 'Events',
                            ],
                        ],
                        'type' => 'Literal',
                        'child_routes' => [
                            'Events' => [
                                'mayTerminate' => true,
                                'options' => [
                                    'route' => '/events/:date/:hourStart/:hourEnd',
                                    'defaults' => [
                                        'controller' => \ZfMetal\Calendar\Controller\ExportController::CLASS,
                                        'action' => 'Events',
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