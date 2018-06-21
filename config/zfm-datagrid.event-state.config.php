<?php

return [
    'zf-metal-datagrid.custom' => [
        'zfmetal-calendar-entity-eventstate' => [
            'gridId' => 'zfmdg_EventState',
            'sourceConfig' => [
                'type' => 'doctrine',
                'doctrineOptions' => [
                    'entityName' => \ZfMetal\Calendar\Entity\EventState::class,
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
                'columns' => 'one',
                'style' => 'vertical',
                'groups' => [
                    
                ],
            ],
            'columnsConfig' => [
                'id' => [
                    'displayName' => 'ID',
                ],
                'name' => [
                    'displayName' => 'Estado',
                ],
                'bgColor' => [
                    'displayName' => 'Color de Fondo',
                ],
                'color' => [
                    'displayName' => 'color',
                ],
                'icon' => [
                    'displayName' => 'Icono',
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