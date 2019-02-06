<?php

return array(
    'service_manager' => array(
        'factories' => array(
            'ZfMetalCalendar.options' => \ZfMetal\Calendar\Factory\Options\ModuleOptionsFactory::class,
            \ZfMetal\Calendar\Service\ShiftService::class => \ZfMetal\Calendar\Factory\Service\ShiftServiceFactory::class
        ),
    ),
);