<?php

return [
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
        'strategies' => array(
            'ViewJsonStrategy',
        ),
        'display_exceptions' => false,
        'display_not_found_reason' => false,
    ],
];
