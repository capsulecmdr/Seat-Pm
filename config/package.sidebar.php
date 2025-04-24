<?php

return [
    'seatpm' => [
        'name' => 'SeAT-PM',
        'route_segment' => 'seat-pm',            // <-- this is the missing key!
        'icon' => 'fas fa-project-diagram',
        'route' => 'seatpm.projects.index',
        'children' => [
            [
                'name' => 'Alliance Projects',
                'permission' => 'seatpm.projects.index',
                'route' => 'seatpm.projects.index',
                'params' => ['scope' => 'alliance'],
            ],
            [
                'name' => 'Corporation Projects',
                'permission' => 'seatpm.projects.index',
                'route' => 'seatpm.projects.index',
                'params' => ['scope' => 'corporation'],
            ],
            [
                'name' => 'Personal Projects',
                'permission' => 'seatpm.projects.index',
                'route' => 'seatpm.projects.index',
                'params' => ['scope' => 'personal'],
            ],
        ]
    ]
];
