<?php
// config/Permissions/seatpm.php

return [
    'projects' => [
        'index' => [
            'label' => 'View Projects',
            'description' => 'View project list',
        ],
        'create' => [
            'label' => 'Create Projects',
            'description' => 'Create new projects',
        ],
        'update' => [
            'label' => 'Update Projects',
            'description' => 'Update projects',
        ],
        'delete' => [
            'label' => 'Delete Projects',
            'description' => 'Delete projects',
        ],
    ],
    'tasks' => [
        'create' => [
            'label' => 'Add Tasks',
            'description' => 'Add tasks to projects',
        ],
        'update' => [
            'label' => 'Edit Tasks',
            'description' => 'Edit tasks',
        ],
        'delete' => [
            'label' => 'Delete Tasks',
            'description' => 'Remove tasks',
        ],
    ],
    'comments' => [
        'create' => [
            'label' => 'Add Comments',
            'description' => 'Add comments',
        ],
        'update' => [
            'label' => 'Edit Comments',
            'description' => 'Edit comments',
        ],
        'delete' => [
            'label' => 'Delete Comments',
            'description' => 'Remove comments',
        ],
    ],
    'super' => [
        'label' => 'Master Project Manager',
        'description' => 'Bypass all project restrictions',
    ],
];
