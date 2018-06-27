<?php

return [
    'zf-metal-datagrid.custom' => [
        'zfmetal-calendar-entity-outofservice' => [
            'gridId' => 'zfmdg_OutOfService',
            'sourceConfig' => [
                'type' => 'doctrine',
                'doctrineOptions' => [
                    'entityName' => \ZfMetal\Calendar\Entity\OutOfService::class,
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
                    'priority' => 10
                ],
                'reason' => [
                    'displayName' => 'Razon',
                    'priority' => 20
                ],
                'start' => [
                    'displayName' => 'Desde',
                    'type' => 'date',
                    'format' => 'Y-m-d',
                    'priority' => 30
                ],
                'end' => [
                    'displayName' => 'Hasta',
                    'type' => 'date',
                    'format' => 'Y-m-d',
                    'priority' => 40
                ],
                'calendar' => [
                    'displayName' => 'Calendario',
                    'type' => 'relational',
                    'priority' => 15
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
                    'enable' => true,
                ],
            ],
        ],
    ],
];