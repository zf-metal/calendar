<?php

return [
    'zf-metal-datagrid.custom' => [
        'zfmetal-calendar-entity-ticket' => [
            'gridId' => 'zfmdg_Ticket',
            'sourceConfig' => [
                'type' => 'doctrine',
                'doctrineOptions' => [
                    'entityName' => \ZfMetal\Calendar\Entity\Ticket::class,
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
                'createdAt' => [
                    'displayName' => 'Fecha de Creacion',
                    'type' => 'date',
                    'format' => 'Y-m-d H:i:s',
                ],
                'updatedAt' => [
                    'displayName' => 'Fecha de Actualizacion',
                    'type' => 'date',
                    'format' => 'Y-m-d H:i:s',
                ],
                'subject' => [
                    'displayName' => 'Asunto',
                ],
                'description' => [
                    'displayName' => 'Descripción',
                ],
                'event' => [
                    'displayName' => 'Evento',
                    'hidden' => true,
                ],
                'state' => [
                    'displayName' => 'Estado',
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