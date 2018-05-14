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
                ],
                'date' => [
                    'type' => 'date',
                    'format' => 'Y-m-d',
                    'displayName' => 'Fecha',
                ],
                'title' => [
                    'displayName' => 'Titulo',
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