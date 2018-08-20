<?php

return [
    'zf-metal-datagrid.custom' => [
        'zfmetal-calendar-entity-calendargroup' => [
            'gridId' => 'zfmdg_CalendarGroup',
            'sourceConfig' => [
                'type' => 'doctrine',
                'doctrineOptions' => [
                    'entityName' => \ZfMetal\Calendar\Entity\CalendarGroup::class,
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
                'name' => [
                    'displayName' => 'Nombre',
                ],
                'calendars' => [
                    'hidden' => true,
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