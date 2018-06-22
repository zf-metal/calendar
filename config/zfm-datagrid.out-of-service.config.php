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
                ],
                'reason' => [
                    'displayName' => 'Razon',
                ],
                'start' => [
                    'displayName' => 'Desde',
                    'type' => 'date',
                    'format' => 'Y-m-d H:i:s',
                ],
                'end' => [
                    'displayName' => 'Hasta',
                    'type' => 'date',
                    'format' => 'Y-m-d H:i:s',
                ],
                'calendar' => [
                    'displayName' => 'Calendario',
                    'type' => 'relational',
                ],
            ],
            'crudConfig' => [
                'enable' => true,
                'displayName' => null,
                'add' => [
                    'enable' => true,
                    'class' => ' glyphicon glyphicon-plus cursor-pointer',
                    'value' => '',
                ],
                'edit' => [
                    'enable' => true,
                    'class' => ' glyphicon glyphicon-edit cursor-pointer',
                    'value' => '',
                ],
                'del' => [
                    'enable' => true,
                    'class' => ' glyphicon glyphicon-trash cursor-pointer',
                    'value' => '',
                ],
                'view' => [
                    'enable' => true,
                    'class' => ' glyphicon glyphicon-list-alt cursor-pointer',
                    'value' => '',
                ],
            ],
        ],
    ],
];