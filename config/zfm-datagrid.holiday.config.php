<?php

return [
    'zf-metal-datagrid.custom' => [
        'zfmetal-calendar-entity-holiday' => [
            'gridId' => 'zfmdg_Holiday',
            'sourceConfig' => [
                'type' => 'doctrine',
                'doctrineOptions' => [
                    'entityName' => \ZfMetal\Calendar\Entity\Holiday::class,
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
                'date' => [
                    'type' => 'date',
                    'format' => 'Y-m-d',
                    'displayName' => 'Fecha',
                    'priority' => 30
                ],
                'title' => [
                    'displayName' => 'Titulo',
                    'priority' => 20
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