<?php

return [
    'module' => [
        [
            'title' => 'Management User',
            'name' => 'user',
            'icon' => 'fa-solid fa-user',
           
            'subTitle' => [
                [
                    'title' => 'User',
                    'route' => '/private/system/user/table-user',
                    'set' => 'table-user'
                ],
                [
                    'title' => 'User Group',
                    'route' => '/private/system/user/cataloge-user',
                    'set' => 'cataloge-user'
                ]
            ]
        ],
        [
            'title' => 'Management Post',
            'icon' => 'fa fa-file',
            'name' => 'post',
            'subTitle' => [
                [
                    'title' => 'Group Post',
                    'route' => '/private/system/post/post-cataloge',
                    'set' => 'post-cataloge'
                ],
                [
                    'title' => 'Post',
                    'route' => '/private/system/post/index',
                    'set' => 'index'
                ]
            ]
        ],
        [
            'title' => 'Config Website',
            'icon' => 'fa-solid fa-wrench',
            'name' => 'configuration',
            'subTitle' => [
                [
                    'title' => 'Management Language',
                    'route' => '/private/system/configuration/language',
                    'set' => 'language'
                ],
            ]
        ],
        
    ]
];