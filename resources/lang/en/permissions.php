<?php

return [
    'seatpm' => [
        'projects' => [
            'index' => [
                'label' => 'View projects',
                'description' => 'View the list of all projects',
            ],
            'create' => [
                'label' => 'Create projects',
                'description' => 'Add new projects',
            ],
            'update' => [
                'label' => 'Edit projects',
                'description' => 'Edit existing projects',
            ],
            'delete' => [
                'label' => 'Delete projects',
                'description' => 'Remove projects',
            ],
        ],
        'tasks' => [
            'create' => [
                'label' => 'Add tasks',
                'description' => 'Add tasks to a project',
            ],
            'update' => [
                'label' => 'Edit tasks',
                'description' => 'Edit existing tasks',
            ],
            'delete' => [
                'label' => 'Delete tasks',
                'description' => 'Remove tasks',
            ],
        ],
        'comments' => [
            'create' => [
                'label' => 'Add comments',
                'description' => 'Add comments to tasks',
            ],
            'update' => [
                'label' => 'Edit comments',
                'description' => 'Edit existing comments',
            ],
            'delete' => [
                'label' => 'Delete comments',
                'description' => 'Remove comments',
            ],
        ],
        'super' => [
            'label' => 'Bypass project restrictions',
            'description' => 'Bypass all project visibility scopes',
        ],
    ],
];
