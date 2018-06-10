<?php

namespace ZfMetal\Calendar;

return [
    'doctrine' => [
        'fixture' => array(
            __NAMESPACE__ => __DIR__ . '/../src/DataFixture',
        ),
        'driver' => array(
            __NAMESPACE__ => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'paths' => __DIR__ . '/../src/Entity'
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__
                )
            )
        )
    ]
];
