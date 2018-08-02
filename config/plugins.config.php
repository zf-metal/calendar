<?php

return array(
    'controller_plugins' => array(
        'factories' => array(
            \ZfMetal\Calendar\Controller\Plugin\Options::class => \ZfMetal\Calendar\Factory\Controller\Plugin\OptionsFactory::class,
        ),
        'aliases' => array(
            'ZfMetalCalendarOptions' => \ZfMetal\Calendar\Controller\Plugin\Options::class,
        ),
    ),
);