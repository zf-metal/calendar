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
                    'priority' => 10
                ],
                'name' => [
                    'displayName' => 'Nombre',
                    'priority' => 20
                ],
                'icon' => [
                    'displayName' => 'Icono',
                    'priority' => 30
                ],
                'bgColor' => [
                    'displayName' => 'Color de Fondo',
                    'priority' => 40
                ],
                'color' => [
                    'displayName' => 'color',
                    'priority' => 50
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