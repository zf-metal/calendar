<?php

return array(
    'controllers' => array(
        'factories' => array(
            \ZfMetal\Calendar\Controller\CalendarController::class => \ZfMetal\Calendar\Factory\Controller\CalendarControllerFactory::class,
            \ZfMetal\Calendar\Controller\ManagerCalendarController::class => \ZfMetal\Calendar\Factory\Controller\ManagerCalendarControllerFactory::class,
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

        ),
    ),
);