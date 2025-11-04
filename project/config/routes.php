<?php

return [
    '' => [
        'GET' => [
            'controller' => 'App\Controller\FrontController',
            'action' => 'index',
            'dependencies' => ['App\Model\Product'],
        ],
    ],

    'product/view' => [
        'GET' => [
            'controller' => 'App\Controller\FrontController',
            'action' => 'view',
            'dependencies' => ['App\Model\Product'],
        ],
    ],

    'admin' => [
        'GET' => [
            'controller' => 'App\Controller\AdminController',
            'action' => 'index',
            'dependencies' => ['App\Model\User', 'App\Model\Product'],
        ],
    ],

    'admin/product/create' => [
        'GET' => [
            'controller' => 'App\Controller\AdminController',
            'action' => 'create',
            'dependencies' => ['App\Model\User', 'App\Model\Product'],
        ],
        'POST' => [
            'controller' => 'App\Controller\AdminController',
            'action' => 'store',
            'dependencies' => ['App\Model\User', 'App\Model\Product'],
        ],
    ],

    'admin/product/edit' => [
        'GET' => [
            'controller' => 'App\Controller\AdminController',
            'action' => 'editForm',
            'dependencies' => ['App\Model\User', 'App\Model\Product'],
        ],
        'POST' => [
            'controller' => 'App\Controller\AdminController',
            'action' => 'edit',
            'dependencies' => ['App\Model\User', 'App\Model\Product'],
        ],
    ],

    'admin/product/delete' => [
        'POST' => [
            'controller' => 'App\Controller\AdminController',
            'action' => 'delete',
            'dependencies' => ['App\Model\User', 'App\Model\Product'],
        ]
    ],

    'admin/login' => [
        'GET' => [
            'controller' => 'App\Controller\AdminController',
            'action' => 'loginForm',
            'dependencies' => ['App\Model\User', 'App\Model\Product'],
        ],
        'POST' => [
            'controller' => 'App\Controller\AdminController',
            'action' => 'login',
            'dependencies' => ['App\Model\User', 'App\Model\Product'],
        ],
    ],

    'admin/register' => [
        'GET' => [
            'controller' => 'App\Controller\AdminController',
            'action' => 'registerAdminForm',
            'dependencies' => ['App\Model\User', 'App\Model\Product'],
        ],
        'POST' => [
            'controller' => 'App\Controller\AdminController',
            'action' => 'register',
            'dependencies' => ['App\Model\User', 'App\Model\Product'],
        ],
    ],

    'admin/logout' => [
        'GET' => [
            'controller' => 'App\Controller\AdminController',
            'action' => 'logout',
            'dependencies' => ['App\Model\User', 'App\Model\Product'],
        ]
    ]
];
