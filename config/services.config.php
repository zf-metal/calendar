<?php

return array(
    'service_manager' => array(
        'factories' => array(
            'ZfMetalCalendar.options' => 'ZfMetal\\Calendar\\Factory\\Options\\ModuleOptionsFactory',
            'ZfMetal\\Calendar.options' => \ZfMetal\Calendar\Factory\Options\ModuleOptionsFactory::class,
        ),
    ),
);