<?php

return [
    'navigation' => [
        'default' => [
            [
                'label' => 'Calendar',
                'detail' => '',
                'icon' => '',
                'route' => 'ZfMetal\\Calendar/ManagerCalendar/List',
            ],
            [
                'label' => 'Feriados',
                'detail' => '',
                'icon' => '',
                'route' => 'ZfMetal\\Calendar/Holiday/Grid',
                'permission' => 'general-admin',
            ],
            [
                'label' => 'Tickets Schedule',
                'detail' => '',
                'icon' => '',
                'route' => 'ZfMetal\\Calendar/Ticket/Schedule',
            ],
            [
                'label' => 'Tickets',
                'detail' => '',
                'icon' => '',
                'route' => 'ZfMetal\\Calendar/Ticket/Grid',
            ],
            [
                'label' => 'Estados de Ticket',
                'detail' => '',
                'icon' => '',
                'route' => 'ZfMetal\\Calendar/TicketState/Grid',
            ],
        ],
    ],
];