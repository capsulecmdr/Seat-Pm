<?php
// plugins/seat-pm/config/Permissions/seatpm.php

return [

    /*
     |--------------------------------------------------------------------------
     | SeAT-PM Permissions
     |--------------------------------------------------------------------------
     |
     | Format:
     |   '<scope>' => [
     |     '<permission>' => [
     |       'label'       => '…',
     |       'description' => '…',
     |     ],
     |     …
     |   ],
     |   'super' => …
     |
     */

    'projects' => [
        'index'   => [
            'label'       => 'View projects',
            'description' => 'View the list of all projects',
        ],
        'create'  => [
            'label'       => 'Create projects',
            'description' => 'Add new projects',
        ],
        'update'  => [
            'label'       => 'Update projects',
            'description' => 'Edit existing projects',
        ],
        'delete'  => [
            'label'       => 'Delete projects',
            'description' => 'Remove projects',
        ],
    ],

    'tasks' => [
        'create' => [
            'label'       => 'Add tasks',
            'description' => 'Add tasks to a project',
        ],
        'update' => [
            'label'       => 'Edit tasks',
            'description' => 'Edit existing tasks',
        ],
        'delete' => [
            'label'       => 'Delete tasks',
            'description' => 'Remove tasks',
        ],
    ],

    'comments' => [
        'create' => [
            'label'       => 'Add comments',
            'description' => 'Add comments to tasks',
        ],
        'update' => [
            'label'       => 'Edit comments',
            'description' => 'Edit existing comments',
        ],
        'delete' => [
            'label'       => 'Delete comments',
            'description' => 'Remove comments',
        ],
    ],

    // A “super” permission to bypass everything
    'super' => [
        'label'       => 'Bypass project restrictions',
        'description' => 'Bypass all project visibility scopes',
    ],

];