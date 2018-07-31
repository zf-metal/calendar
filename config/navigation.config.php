<?php

return [
    'navigation' => [
        'default' => [
            [
                'label' => 'Agenda',
                'detail' => '',
                'icon' => '',
                'permission' => 'general-user',
                'uri' => '',
                'pages' => [
                    [
                        'label' => 'Calendarios',
                        'detail' => '',
                        'icon' => '',
                        'permission' => 'general-user',
                        'route' => 'ZfMetalCalendar/Calendar/Grid',
                    ],
                    [
                        'label' => 'Feriados',
                        'detail' => '',
                        'icon' => '',
                        'permission' => 'general-user',
                        'route' => 'ZfMetalCalendar/Holiday/Grid',
                    ],
                    [
                        'label' => 'Licencias',
                        'detail' => '',
                        'icon' => '',
                        'permission' => 'general-user',
                        'route' => 'ZfMetalCalendar/OutOfService/Grid',
                    ],
                    [
                        'label' => 'Tipos de Evento',
                        'detail' => '',
                        'icon' => '',
                        'permission' => 'general-user',
                        'route' => 'ZfMetalCalendar/EventType/Grid',
                    ],
                    [
                        'label' => 'Estados de Evento',
                        'detail' => '',
                        'icon' => '',
                        'permission' => 'general-user',
                        'route' => 'ZfMetalCalendar/EventState/Grid',
                    ],
                    [
                        'label' => 'Eventos',
                        'detail' => '',
                        'icon' => '',
                        'permission' => 'general-user',
                        'route' => 'ZfMetalCalendar/Event/Grid',
                    ],
                    [
                        'label' => 'Programacion',
                        'detail' => '',
                        'icon' => '',
                        'permission' => 'general-user',
                        'route' => 'ZfMetalCalendar/EventSchedule/Schedule',
                    ],
                ],
            ],
        ],
    ],
];