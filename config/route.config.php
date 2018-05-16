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
                    'Ticket' => [
                        'mayTerminate' => false,
                        'options' => [
                            'defaults' => [
                                'controller' => \ZfMetal\Calendar\Controller\TicketScheduleController::CLASS,
                                'action' => 'schedule',
                            ],
                            'route' => '/ticket',
                        ],
                        'type' => 'Literal',
                        'child_routes' => [
                            'Schedule' => [
                                'mayTerminate' => true,
                                'options' => [
                                    'defaults' => [
                                        'controller' => \ZfMetal\Calendar\Controller\TicketScheduleController::CLASS,
                                        'action' => 'schedule',
                                    ],
                                    'route' => '/schedule',
                                ],
                                'type' => 'Segment',
                            ],
                            'Grid' => [
                                'mayTerminate' => true,
                                'options' => [
                                    'defaults' => [
                                        'controller' => \ZfMetal\Calendar\Controller\TicketController::CLASS,
                                        'action' => 'grid',
                                    ],
                                    'route' => '/grid',
                                ],
                                'type' => 'Segment',
                            ],
                        ],
                    ],
                    'TicketSchedule' => [
                        'mayTerminate' => false,
                        'options' => [
                            'defaults' => [
                                'controller' => \ZfMetal\Calendar\Controller\TicketScheduleController::CLASS,
                                'action' => 'schedule',
                            ],
                            'route' => '/ticket-schedule',
                        ],
                        'type' => 'Literal',
                        'child_routes' => [
                            'Schedule' => [
                                'mayTerminate' => true,
                                'options' => [
                                    'defaults' => [
                                        'controller' => \ZfMetal\Calendar\Controller\TicketScheduleController::CLASS,
                                        'action' => 'schedule',
                                    ],
                                    'route' => '/schedule[/:date]',
                                ],
                                'type' => 'Segment',
                            ],
                        ],
                    ],
                    'TicketState' => [
                        'mayTerminate' => false,
                        'options' => [
                            'defaults' => [
                                'controller' => \ZfMetal\Calendar\Controller\TicketStateController::CLASS,
                                'action' => 'grid',
                            ],
                            'route' => '/ticket-state',
                        ],
                        'type' => 'Literal',
                        'child_routes' => [
                            'Grid' => [
                                'mayTerminate' => true,
                                'options' => [
                                    'defaults' => [
                                        'controller' => \ZfMetal\Calendar\Controller\TicketStateController::CLASS,
                                        'action' => 'grid',
                                    ],
                                    'route' => '/grid',
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
                        'child_routes' => [
                            'calendars' => [
                                'mayTerminate' => false,
                                'options' => [
                                    'route' => '/calendars[/:id]',
                                    'defaults' => [
                                        'controller' => \ZfMetal\Calendar\Controller\ApiCalendarController::CLASS,
                                    ],
                                ],
                                'type' => 'Segment',
                            ],
                            'events' => [
                                'mayTerminate' => false,
                                'options' => [
                                    'route' => '/events[/:id]',
                                    'defaults' => [
                                        'controller' => \ZfMetal\Calendar\Controller\ApiEventController::CLASS,
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