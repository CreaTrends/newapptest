<?php

return [
    'role_structure' => [
        'superadministrator' => [
            'users' => 'c,r,u,d',
            'acl' => 'c,r,u,d',
            'profile' => 'r,u'
        ],
        'administrator' => [
            'users' => 'c,r,u,d',
            'profile' => 'r,u'
        ],
        'teacher' => [
            'users' => 'c,r,u,d',
            'profile' => 'r,u'
        ],
        'parent' => [
            'profile' => 'r,u'
        ],
        'student' => [
            'profile' => 'r'
        ],
        'child' => [
            'profile' => 'r'
        ],
        'user' => [
            'profile' => 'r,u'
        ],
    ],
    'permission_structure' => [],
    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
