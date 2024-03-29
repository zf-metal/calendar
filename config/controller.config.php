<?php

return array(
    'controllers' => array(
        'factories' => array(
            'ZfMetal\\Calendar\\Controller\\AccountController' => 'ZfMetal\\Calendar\\Factory\\Controller\\AccountControllerFactory',
            \ZfMetal\Calendar\Controller\CalendarController::class => \ZfMetal\Calendar\Factory\Controller\CalendarControllerFactory::class,
            \ZfMetal\Calendar\Controller\ManagerCalendarController::class => \ZfMetal\Calendar\Factory\Controller\ManagerCalendarControllerFactory::class,
            \ZfMetal\Calendar\Controller\CalendarApiController::class => \ZfMetal\Calendar\Factory\Controller\CalendarApiControllerFactory::class,
            \ZfMetal\Calendar\Controller\HolidayController::class => \ZfMetal\Calendar\Factory\Controller\HolidayControllerFactory::class,
            \ZfMetal\Calendar\Controller\DayController::class => \ZfMetal\Calendar\Factory\Controller\DayControllerFactory::class,
            \ZfMetal\Calendar\Controller\ApiCalendarController::class => \ZfMetal\Calendar\Factory\Controller\ApiCalendarControllerFactory::class,
            \ZfMetal\Calendar\Controller\ApiEventController::class => \ZfMetal\Calendar\Factory\Controller\ApiEventControllerFactory::class,
            \ZfMetal\Calendar\Controller\HomeController::class => \ZfMetal\Calendar\Factory\Controller\HomeControllerFactory::class,
            \ZfMetal\Calendar\Controller\EventScheduleController::class => \ZfMetal\Calendar\Factory\Controller\EventScheduleControllerFactory::class,
            \ZfMetal\Calendar\Controller\EventController::class => \ZfMetal\Calendar\Factory\Controller\EventControllerFactory::class,
            \ZfMetal\Calendar\Controller\EventStateController::class => \ZfMetal\Calendar\Factory\Controller\EventStateControllerFactory::class,
            \ZfMetal\Calendar\Controller\EventTypeController::class => \ZfMetal\Calendar\Factory\Controller\EventTypeControllerFactory::class,
            \ZfMetal\Calendar\Controller\OutOfServiceController::class => \ZfMetal\Calendar\Factory\Controller\OutOfServiceControllerFactory::class,
            \ZfMetal\Calendar\Controller\InitController::class => \ZfMetal\Calendar\Factory\Controller\InitControllerFactory::class,
            \ZfMetal\Calendar\Controller\CalendarGroupController::class => \ZfMetal\Calendar\Factory\Controller\CalendarGroupControllerFactory::class,
            \ZfMetal\Calendar\Controller\ApiStartController::class => \ZfMetal\Calendar\Factory\Controller\ApiStartControllerFactory::class,
            \ZfMetal\Calendar\Controller\ExportController::class => \ZfMetal\Calendar\Factory\Controller\ExportControllerFactory::class,
            \ZfMetal\Calendar\Controller\BranchOfficeController::class => \ZfMetal\Calendar\Factory\Controller\BranchOfficeControllerFactory::class,
            \ZfMetal\Calendar\Controller\ServiceSearchController::class => \ZfMetal\Calendar\Factory\Controller\ServiceSearchControllerFactory::class,
            \ZfMetal\Calendar\Controller\ClientController::class => \ZfMetal\Calendar\Factory\Controller\CategoryControllerFactory::class,
            \ZfMetal\Calendar\Controller\ServiceController::class => \ZfMetal\Calendar\Factory\Controller\ServiceControllerFactory::class,
            \ZfMetal\Calendar\Controller\EventSearchController::class => \ZfMetal\Calendar\Factory\Controller\EventSearchControllerFactory::class,
            \ZfMetal\Calendar\Controller\ShiftController::class => \ZfMetal\Calendar\Factory\Controller\ShiftControllerFactory::class,
            \ZfMetal\Calendar\Controller\AppointmentController::class => \ZfMetal\Calendar\Factory\Controller\AppointmentControllerFactory::class,
            \ZfMetal\Calendar\Controller\AppointmentApiController::class => \ZfMetal\Calendar\Factory\Controller\AppointmentApiControllerFactory::class,
            \ZfMetal\Calendar\Controller\CategoryController::class => \ZfMetal\Calendar\Factory\Controller\CategoryControllerFactory::class,
        ),
    ),
);
