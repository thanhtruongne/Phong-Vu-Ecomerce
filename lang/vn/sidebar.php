<?php

return [
    'module' => [
        [
            'title' => 'Quản lý thành viên',
            'name' => ['user.table-user','user.cateloge-user'],
            'icon' => 'fa-solid fa-user',
             
            'subTitle' => [
                [
                    'title' => 'QL thành viên',
                    'route' => '/private/system/user/table-user',
                    'set' => 'user.table-user'
                ],
                [
                    'title' => 'QL nhóm thành viên',
                    'route' => '/private/system/user/cataloge-user',
                    'set' => 'user.cataloge-user'
                ],
            ]
        ],
        [
            'title' => 'Quản lý bài viết',
            'icon' => 'fa fa-file',
            'name' => ['post.index','post.post-cataloge'],
            'subTitle' => [
                [
                    'title' => 'QL nhóm bài viết',
                    'route' => '/private/system/post/post-cataloge',
                    'set' => 'post.post-cataloge'
                ],
                [
                    'title' => 'QL bài viết',
                    'route' => '/private/system/post/index',
                    'set' => 'post.index'
                ]
                
            ]
        ],
        [
            'title' => 'Quản lý banner và slide',
            'icon' => 'fa fa-file',
            'name' => ['slider','widget'],
            'subTitle' => [
                [
                    'title' => 'QL slide',
                    'route' => '/private/system/slider',
                    'set' => 'slider'
                ],    
                [
                    'title' => 'QL widgets',
                    'route' => '/private/system/widget',
                    'set' => 'widget'
                ],    
            ]
        ],
        [
            'title' => 'Quản lý sản phẩm',
            'name' => ['product','product.cateloge','attribute.cateloge','attribute'],
            'icon' => 'fa-brands fa-slack',
           
            'subTitle' => [
                [
                    'title' => 'QL sản phẩm',
                    'route' => '/private/system/product',
                    'set' => 'product'
                ],
                [
                    'title' => 'QL nhóm sản phẩm',
                    'route' => '/private/system/product/cateloge',
                    'set' => 'product.cateloge'
                ],
                [
                    'title' => 'QL loại thuộc tính',
                    'route' => '/private/system/attribute/cateloge',
                    'set' => 'attribute.cateloge'
                ],
                [
                    'title' => 'QL  thuộc tính',
                    'route' => '/private/system/attribute',
                    'set' => 'attribute'
                ],
             
            ]
        ],
        [
            'title' => 'Quản lý sale vả marketing',
            'name' => ['promotion','source'],
            'icon' => 'fa-brands fa-slack',
           
            'subTitle' => [
                [
                    'title' => 'QL sale',
                    'route' => '/private/system/promotion',
                    'set' => 'promotion'
                ],
                [
                    'title' => 'QL source',
                    'route' => '/private/system/source',
                    'set' => 'source'
                ],
            ]
        ],
        [
            'title' => 'Quản lý khách hàng',
            'name' => ['customer','customer.cateloge'],
            'icon' => 'fa-brands fa-slack',
           
            'subTitle' => [
                [
                    'title' => 'QL khách hàng',
                    'route' => '/private/system/customer',
                    'set' => 'customer'
                ],
                [
                    'title' => 'QL nhóm khách hàng',
                    'route' => '/private/system/customer/cateloge',
                    'set' => 'customer.cateloge'
                ],
            ]
        ],
        [
            'title' => 'Quản lý menu',
            'name' => ['menu'],
            'icon' => 'fa-brands fa-slack',
           
            'subTitle' => [
                [
                    'title' => 'Thiết lập menu',
                    'route' => '/private/system/menu',
                    'set' => 'menu'
                ],
            ]
        ],
        [
            'title' => 'Cấu hình trang web',
            'icon' => 'fa-solid fa-wrench',
            'name' => ['configuration.language','configuration.permissions','configuration.module','configuration.setting'],
            'subTitle' => [
                [
                    'title' => 'QL ngôn ngữ',
                    'route' => '/private/system/configuration/language',
                    'set' => 'configuration.language'
                ],
                [
                    'title' => 'QL quyền',
                    'route' => '/private/system/configuration/permissions',
                    'set' => 'configuration.permissions'
                ],
                [
                    'title' => 'QL module',
                    'route' => '/private/system/configuration/module',
                    'set' => 'configuration.module'
                ],
                [
                    'title' => 'Cấu hình chung',
                    'route' => '/private/system/configuration/setting',
                    'set' => 'configuration.setting'
                ],
            ]
        ],
        
    ]
];