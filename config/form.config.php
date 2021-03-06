<?php

return [
    'form_elements' => [
        'factories' => [
            \ZfMetal\Calendar\Form\ScheduleForm::class => \Zend\ServiceManager\Factory\InvokableFactory::class,
            \ZfMetal\Calendar\Form\CalendarForm::class => \Zend\ServiceManager\Factory\InvokableFactory::class,
            \ZfMetal\Calendar\Form\AppointmentConfigForm::class => \Zend\ServiceManager\Factory\InvokableFactory::class,
            \ZfMetal\Calendar\Form\DateForm::class => \Zend\ServiceManager\Factory\InvokableFactory::class,
            \ZfMetal\Calendar\Form\AppointmentForm::class => \Zend\ServiceManager\Factory\InvokableFactory::class,
        ],
    ],
];