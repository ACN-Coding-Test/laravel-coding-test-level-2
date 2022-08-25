<?php

return [
    'ADMIN' => [
        // Users
        'list:users',
        'view:user',
        'create:user',
        'update:user',
        'delete:user',
    ],
    'PRODUCT_OWNER' => [

        // Projects
        'list:projects',
        'view:project',
        'create:project',
        'update:project',
        'delete:project',

        // Tasks
        'list:tasks',
        'view:task',
        'create:task',
        'update:task',
        'assign:task',
        'delete:task',
    ],

    'TEAM_MEMBER' => [
        // Tasks
        'list:own:tasks',
        'view:own:task',
        'update:own:task',
    ]
];
