<?php

return [
    'zf-metal-datagrid.custom' => [
        'zfmetal-calendar-entity-event' => [
            'gridId' => 'zfmdg_Event',
            'sourceConfig' => [
                'type' => 'doctrine',
                'doctrineOptions' => [
                    'entityName' => \ZfMetal\Calendar\Entity\Event::class,
                    'entityManager' => 'doctrine.entitymanager.orm_default',
                ],
            ],
            'multi_filter_config' => [
                'enable' => true,
                'properties_disabled' => [
                    
                ],
            ],
            'multi_search_config' => [
                'enable' => false,
                'properties_enabled' => [
                    
                ],
            ],
            'formConfig' => [
                'columns' => \ZfMetal\Commons\Consts::COLUMNS_ONE,
                'style' => \ZfMetal\Commons\Consts::STYLE_VERTICAL,
                'groups' => [
                    
                ],
            ],
            'columnsConfig' => [
                'id' => [
                    'displayName' => 'ID',
                ],
                'calendar' => [
                    'type' => 'relational',
                ],
                'ticket' => [
                    'displayName' => 'Ticket',
                    'hidden' => true
                ],
                'start' => [
                    'type' => 'date',
                    'format' => 'Y-m-d H:i:s',
                    'hidden' => true
                ],
                'end' => [
                    'type' => 'date',
                    'format' => 'Y-m-d H:i:s',
                    'hidden' => true
                ],
                'location' => [
                    'displayName' => 'Ubicacion',
                ],
                'state' => [
                    'displayName' => 'Estado',
                    'type' => 'relational',
                ],
                'description' => [
                    'hidden' => true
                ],
                'duration' => [
                    'hidden' => true
                ],
                'lat' => [
                    'hidden' => true
                ],
                'lng' => [
                    'hidden' => true
                ],
                'postalCode' => [
                    'hidden' => true
                ],
            ],
            'crudConfig' => [
                'enable' => true,
                'displayName' => null,
                'add' => [
                    'enable' => true,
                ],
                'edit' => [
                    'enable' => true,
                ],
                'del' => [
                    'enable' => true,
                ],
                'view' => [
                    'enable' => false,
                ],
            ],
        ],
    ],
];