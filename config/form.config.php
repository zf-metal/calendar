<?php

return [
    'form_elements' => [
        'factories' => [
            \ZfMetal\Calendar\Form\ScheduleForm::class => \Zend\ServiceManager\Factory\InvokableFactory::class,
            \ZfMetal\Calendar\Form\CalendarForm::class => \Zend\ServiceManager\Factory\InvokableFactory::class,
            \ZfMetal\Calendar\Form\PredefinedEventsForm::class => \Zend\ServiceManager\Factory\InvokableFactory::class,
            \ZfMetal\Calendar\Form\DateForm::class => \Zend\ServiceManager\Factory\InvokableFactory::class,
        ],
        'initializers' => [
            'ObjectManagerInitializer' => function ($container,  $formElement) {
                if ($formElement instanceOf \DoctrineModule\Persistence\ObjectManagerAwareInterface) {
                    $em = $container->get("doctrine.entitymanager.orm_default");
                    $formElement->setObjectManager($em);
                }
            }
        ]
    ],
];