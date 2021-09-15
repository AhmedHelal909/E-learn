<?php

return [
    'role_structure' => [
        'super' => [
            'users'      => 'c,r,u,d',
            'roles'      => 'c,r,u,d',
            'categories' => 'c,r,u,d',
            'countries' => 'c,r,u,d',
            'classrooms' => 'c,r,u,d',
            'subjects' => 'c,r,u,d',
            'terms' => 'c,r,u,d',
            'teachers' => 'c,r,u,d',
            'students' => 'c,r,u,d',

           
        ],
    ],
    // 'permission_structure' => [
    //     'cru_user' => [
    //         'profile' => 'c,r,u'
    //     ],
    // ],
    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
