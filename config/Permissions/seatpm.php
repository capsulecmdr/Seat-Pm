<?php
// config/Permissions/seatpm.php

return [
    'projects' => [
        'index' => [
            'description' => 'View project list',
        ],
        'create' => [
            'description' => 'Create new projects',
        ],
        'update' => [
            'description' => 'Update projects',
        ],
        'delete' => [
            'description' => 'Delete projects',
        ],
    ],
    'tasks' => [
        'create' => [
            'description' => 'Add tasks to projects',
        ],
        'update' => [
            'description' => 'Edit tasks',
        ],
        'delete' => [
            'description' => 'Remove tasks',
        ],
    ],
    'comments' => [
        'create' => [
            'description' => 'Add comments',
        ],
        'update' => [
            'description' => 'Edit comments',
        ],
        'delete' => [
            'description' => 'Remove comments',
        ],
    ],
    'super' => [
        'description' => 'Bypass all project restrictions',
    ],
];
