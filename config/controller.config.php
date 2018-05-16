<?php

return array(
    'controllers' => array(
        'factories' => array(
            \ZfMetal\Calendar\Controller\CalendarController::class => \ZfMetal\Calendar\Factory\Controller\CalendarControllerFactory::class,
            \ZfMetal\Calendar\Controller\ManagerCalendarController::class => \ZfMetal\Calendar\Factory\Controller\ManagerCalendarControllerFactory::class,
            \ZfMetal\Calendar\Controller\HolidayController::class => \ZfMetal\Calendar\Factory\Controller\HolidayControllerFactory::class,
            \ZfMetal\Calendar\Controller\DayController::class => \ZfMetal\Calendar\Factory\Controller\DayControllerFactory::class,
            \ZfMetal\Calendar\Controller\TicketController::class => \ZfMetal\Calendar\Factory\Controller\TicketControllerFactory::class,
            \ZfMetal\Calendar\Controller\TicketScheduleController::class => \ZfMetal\Calendar\Factory\Controller\TicketScheduleControllerFactory::class,
            \ZfMetal\Calendar\Controller\TicketStateController::class => \ZfMetal\Calendar\Factory\Controller\TicketStateControllerFactory::class,
           \ZfMetal\Calendar\Controller\ApiCalendarController::class => \ZfMetal\Calendar\Factory\Controller\ApiCalendarControllerFactory::class,
            \ZfMetal\Calendar\Controller\ApiEventController::class => \ZfMetal\Calendar\Factory\Controller\ApiEventControllerFactory::class,
        ),
    ),
);