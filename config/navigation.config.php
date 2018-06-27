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
                        'route' => 'ZfMetal\\Calendar/Calendar/Grid',
                    ],
                    [
                        'label' => 'Feriados',
                        'detail' => '',
                        'icon' => '',
                        'permission' => 'general-user',
                        'route' => 'ZfMetal\\Calendar/Holiday/Grid',
                    ],
                    [
                        'label' => 'Licencias',
                        'detail' => '',
                        'icon' => '',
                        'permission' => 'general-user',
                        'route' => 'ZfMetal\\Calendar/OutOfService/Grid',
                    ],
                    [
                        'label' => 'Tipos de Evento',
                        'detail' => '',
                        'icon' => '',
                        'permission' => 'general-user',
                        'route' => 'ZfMetal\\Calendar/EventType/Grid',
                    ],
                    [
                        'label' => 'Estados de Evento',
                        'detail' => '',
                        'icon' => '',
                        'permission' => 'general-user',
                        'route' => 'ZfMetal\\Calendar/EventState/Grid',
                    ],
                    [
                        'label' => 'Eventos',
                        'detail' => '',
                        'icon' => '',
                        'permission' => 'general-user',
                        'route' => 'ZfMetal\\Calendar/Event/Grid',
                    ],
                    [
                        'label' => 'Programacion',
                        'detail' => '',
                        'icon' => '',
                        'permission' => 'general-user',
                        'route' => 'ZfMetal\\Calendar/EventSchedule/Schedule',
                    ],
                ],
            ],
        ],
    ],
];