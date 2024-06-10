<?php

return [
    'module' => [
        [
            'title' => 'Quản lý thành viên',
            'name' => 'user',
            'icon' => 'fa-solid fa-user',
           
            'subTitle' => [
                [
                    'title' => 'QL thành viên',
                    'route' => '/private/system/user/table-user',
                    'set' => 'table-user'
                ],
                [
                    'title' => 'QL nhóm thành viên',
                    'route' => '/private/system/user/cataloge-user',
                    'set' => 'cataloge-user'
                ]
            ]
        ],
        [
            'title' => 'Quản lý bài viết',
            'icon' => 'fa fa-file',
            'name' => 'post',
            'subTitle' => [
                [
                    'title' => 'QL nhóm bài viết',
                    'route' => '/private/system/post/post-cataloge',
                    'set' => 'post-cataloge'
                ],
                [
                    'title' => 'QL bài viết',
                    'route' => '/private/system/post/index',
                    'set' => 'index'
                ]
            ]
        ],
        [
            'title' => 'Cấu hình trang web',
            'icon' => 'fa-solid fa-wrench',
            'name' => 'configuration',
            'subTitle' => [
                [
                    'title' => 'QL ngôn ngữ',
                    'route' => '/private/system/configuration/language',
                    'set' => 'language'
                ],
               
               
            ]
        ],
        
    ]
];