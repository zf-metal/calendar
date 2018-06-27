<?php

return [
    'zf-metal-datagrid.custom' => [
        'zfmetal-calendar-entity-calendar' => [
            'gridId' => 'zfmdg_Calendar',
            'sourceConfig' => [
                'type' => 'doctrine',
                'doctrineOptions' => [
                    'entityName' => \ZfMetal\Calendar\Entity\Calendar::class,
                    'entityManager' => 'doctrine.entitymanager.orm_default',
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
                'name' => [
                    'displayName' => 'Nombre',
                    'priority' => 20
                ],
                'user' => [
                    'displayName' => 'Usuario',
                    'priority' => 30
                ],
                'description' => [
                    'displayName' => 'Descripción',
                    'hidden' => true,
                ],
                'schedules' => [
                    'displayName' => 'schedules',
                    'hidden' => true,
                ],
                'events' => [
                    'displayName' => 'Eventos',
                    'hidden' => true,
                ],
                'specificSchedules' => [
                    'displayName' => 'Programaciones Especificas',
                    'hidden' => true,
                ],
                'predefinedEvents' => [
                    'displayName' => 'Eventos predefinidos',
                    'hidden' => true,
                ]
            ],
            'crudConfig' => [
                'enable' => true,
                'displayName' => null,
                'add' => [
                    'enable' => true,
                    'action' => 'href="/zfmc/manager-calendar/manage"',
                ],
                'edit' => [
                    'enable' => true,
                    'action' => 'href="/zfmc/manager-calendar/manage/{{id}}"',
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