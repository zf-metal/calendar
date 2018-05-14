<?php

return [
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ],
];
