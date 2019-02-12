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
                    'ServiceSearch' => [
                        'type' => \Zend\Router\Http\Literal::class,
                        'mayTerminate' => true,
                        'options' => [
                            'defaults' => [
                                'controller' => \ZfMetal\Calendar\Controller\ServiceSearchController::class,
                                'action' => 'search',
                            ],
                            'route' => '/serviceSearch',
                        ],
                    ],
                    'EventsByServiceYearMonth' => [
                        'type' => \Zend\Router\Http\Segment::class,
                        'mayTerminate' => true,
                        'options' => [
                            'route' => '/api/events/search/byServiceYearMonth/:service/:year/:month',
                            'defaults' => [
                                'controller' => \ZfMetal\Calendar\Controller\EventSearchController::class,
                                'action' => 'searchByServiceYearMonth',
                            ],
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
                        'type' => \Zend\Router\Http\Literal::class,
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
                                'type' => \Zend\Router\Http\Segment::class,
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
                        'type' => \Zend\Router\Http\Literal::class,
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
                                'type' => \Zend\Router\Http\Segment::class,
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
                                'type' => \Zend\Router\Http\Segment::class,
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
                        'type' => \Zend\Router\Http\Literal::class,
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
                                'type' => \Zend\Router\Http\Segment::class,
                            ],
                        ],
                    ],
                    'Api' => [
                        'type' => \Zend\Router\Http\Literal::class,
                        'mayTerminate' => false,
                        'options' => [
                            'route' => '/api',
                        ],
                        'child_routes' => [
                            'entity' => [
                                'type' => \Zend\Router\Http\Segment::class,
                                'mayTerminate' => false,
                                'options' => [
                                    'route' => '/:entityAlias[/:id]',
                                    'defaults' => [
                                        'controller' => 'ZfMetal\\Restful\\Controller\\MainController',
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
                        'type' => \Zend\Router\Http\Literal::class,
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
                        'type' => \Zend\Router\Http\Literal::class,
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
                                'type' => \Zend\Router\Http\Segment::class,
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
                        'type' => \Zend\Router\Http\Literal::class,
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
                                'type' => \Zend\Router\Http\Segment::class,
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
                        'type' => \Zend\Router\Http\Literal::class,
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
                                'type' => \Zend\Router\Http\Segment::class,
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
                        'type' => \Zend\Router\Http\Literal::class,
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
                                'type' => \Zend\Router\Http\Segment::class,
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
                        'type' => \Zend\Router\Http\Literal::class,
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
                                'type' => \Zend\Router\Http\Segment::class,
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
                        'type' => \Zend\Router\Http\Literal::class,
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
                                'type' => \Zend\Router\Http\Segment::class,
                            ],
                        ],
                    ],
                    'api' => [
                        'mayTerminate' => false,
                        'options' => [
                            'route' => '/api',
                        ],
                        'type' => \Zend\Router\Http\Literal::class,
                    ],
                    'Export' => [
                        'mayTerminate' => false,
                        'options' => [
                            'route' => '/export',
                            'defaults' => [
                                'controller' => 'ZfMetal\\Calendar\\Controller\\ExportController',
                                'action' => 'Events',
                            ],
                        ],
                        'type' => \Zend\Router\Http\Literal::class,
                        'child_routes' => [
                            'Events' => [
                                'mayTerminate' => true,
                                'options' => [
                                    'route' => '/events/:date/:hourStart/:hourEnd',
                                    'defaults' => [
                                        'controller' => 'ZfMetal\\Calendar\\Controller\\ExportController',
                                        'action' => 'Events',
                                    ],
                                ],
                                'type' => \Zend\Router\Http\Segment::class,
                            ],
                        ],
                    ],
                    'Account' => [
                        'mayTerminate' => false,
                        'options' => [
                            'route' => '/account',
                            'defaults' => [
                                'controller' => \ZfMetal\Calendar\Controller\AccountController::CLASS,
                                'action' => 'grid',
                            ],
                        ],
                        'type' => \Zend\Router\Http\Literal::class,
                        'child_routes' => [
                            'Grid' => [
                                'mayTerminate' => true,
                                'options' => [
                                    'route' => '/grid',
                                    'defaults' => [
                                        'controller' => \ZfMetal\Calendar\Controller\AccountController::CLASS,
                                        'action' => 'grid',
                                    ],
                                ],
                                'type' => \Zend\Router\Http\Segment::class,
                            ],
                        ],
                    ],
                    'BranchOffice' => [
                        'mayTerminate' => false,
                        'options' => [
                            'route' => '/branch-office',
                            'defaults' => [
                                'controller' => \ZfMetal\Calendar\Controller\BranchOfficeController::CLASS,
                                'action' => 'grid',
                            ],
                        ],
                        'type' => \Zend\Router\Http\Literal::class,
                        'child_routes' => [
                            'Grid' => [
                                'mayTerminate' => true,
                                'options' => [
                                    'route' => '/grid',
                                    'defaults' => [
                                        'controller' => \ZfMetal\Calendar\Controller\BranchOfficeController::CLASS,
                                        'action' => 'grid',
                                    ],
                                ],
                                'type' => \Zend\Router\Http\Segment::class,
                            ],
                        ],
                    ],
                    'Shift' => [
                        'mayTerminate' => false,
                        'options' => [
                            'route' => '/appointments',
                            'defaults' => [
                                'controller' => \ZfMetal\Calendar\Controller\ShiftController::CLASS,
                                'action' => 'availableShifts',
                            ],
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
];