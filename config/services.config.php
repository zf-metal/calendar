<?php

return array(
    'service_manager' => array(
        'factories' => array(
            'ZfMetalCalendar.options' => \ZfMetal\Calendar\Factory\Options\ModuleOptionsFactory::class,
            \ZfMetal\Calendar\Service\AppointmentService::class => \ZfMetal\Calendar\Factory\Service\AppointmentServiceFactory::class
        ),
    ),
);