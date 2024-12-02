<?php

namespace App\Http\ViewComposers;
use Illuminate\View\View;

class LeftMenuComposer  {
    protected $leftMenuBackend;

    public function __construct()
    {
      $this->leftMenuComposer();
    }
    /**
     * Bootstrap any application services.
     */
    public function compose(View $view)
    {
        $view->with('leftMenuBackend',$this->leftMenuComposer());
    }
    
    private function leftMenuComposer(){
        $item = [
            
            'dashboard' => [
                'id' => '1',
                'name' => trans('admin.dashboard'),
                'url' => route('private-system.dashboard'),
                'url_name'=> 'dashboard',
                'is_open' => 1,
                'icon' => '<i class="fas fa-tachometer-alt"></i>',
                // 'permission' => User::isRoleManager(),
                'url_name' => 'dashboard',
                'url_child' => [],
            ],
            // 'manager_menus' => [
            //     'id' => 5,
            //     'name' => trans('admin.manager_menu'),
            //     'url' => '#',
            //     'is_open' => 1,
            //     'icon' => '<i class="fas fa-tachometer-alt"></i>',
            //     'url_name' => 'menu',
            //     'url_item_child' => ['menus_cateloge','menus'],
            //     'item_childs' => [
            //         [
            //             'name' => trans('admin.manager_menu'),
            //             'url' =>route('private-system.product-cateloge'),
            //             'url_name'=> 'menus',
            //             'icon' => '<i class="fa fa-archive"></i>',
            //             // 'permission' => User::canPermissionCompetencyReport(),
            //         ],
            //         [
            //             'name' => trans('admin.manager_menu_cateloge'),
            //             'url' => route('private-system.menus.cateloge.index'),
            //             'url_name'=> 'menus/cateloge',
            //             'icon' => '<i class="fa fa-archive"></i>',
            //             // 'permission' => User::canPermissionCompetencyReport(),
            //         ],
            //     ],
            // ],
            'manager_user' => [
                'id' => 2,
                'name' => trans('admin.manager_user'),
                'url' => '#', 
                 'is_open' => '',
                 'url_name'=> 'manager_user',
                'icon' => '<i class="fas fa-home"></i>',
                // 'permission' => ,
                'url_item_child' => ['info_products_rent', 'product_family_create'],
                'item_childs' => [
                    // [
                    //     'name' => trans('market.info_products_rent'),
                    //     'url' =>'',
                    //     'url_name'=> 'product_rent',
                    //     'icon' => '<i class="fas fa-house-user"></i>',
                    //     // 'permission' => User::canPermissionCompetencyReport(),
                    // ],
                ],
            ],
            'manager_categories' => [
                'id' => 4,
                'name' => trans('admin.manager_categories'),
                'url' => route('private-system.categories'),
                 'is_open' => '',
                 'url_name'=> 'categories',
                'icon' => '<i class="fas fa-atom"></i>',
                // 'permission' => ,
                'url_item_child' => ['product_family_info', 'product_family_create'],
                'item_childs' => [
                    // [
                    //     'name' => trans('market.product_electronics_manager'),
                    //     'url' =>'',
                    //     'url_name'=> 'products',
                    //     'icon' => '<i class="fas fa-atom"></i>',
                    //     'item_childs' => [
                    //         [
                    //             'name' => trans('market.product_electronics'),
                    //             // 'url' => route('products.electronic'),
                    //             'url' => '',
                    //             'url_name'=> 'electronic',
                    //             'icon' => '<i class="fas fa-atom"></i>',
                    //         ],
                    //         [
                    //             'name' => trans('market.product_electronics_category'),
                    //             // 'url' => route('products.electronic'),
                    //             'url' => '',
                    //             'url_name'=> 'electronic/categories',
                    //             'icon' => '<i class="fas fa-atom"></i>',
                    //         ]
                    //     ]
                    // ],
                ],
            ],
            'manager_product' => [
                'id' => 3,
                'name' => trans('admin.manager_product'),
                'url' => '',
                 'is_open' => '',
                 'url_name'=> 'manager-product',
                'icon' => '<i class="fas fa-users"></i>',
                // 'permission' => ,
                'url_item_child' => ['manager-product-attribute', 'manager-product-categories'],
                'item_childs' => [
                    [
                        'name' => trans('admin.manager_product'),
                        'url' =>route('private-system.product'),
                        'url_name'=> 'product',
                        'icon' => '<i class="fa fa-archive"></i>',
                        // 'permission' => User::canPermissionCompetencyReport(),
                    ],
                    [
                        'name' => trans('admin.manager_product_categories'),
                        'url' =>route('private-system.product-cateloge'),
                        'url_name'=> 'product/categories',
                        'icon' => '<i class="fa fa-archive"></i>',
                        // 'permission' => User::canPermissionCompetencyReport(),
                    ],
                    [
                        'name' => trans('admin.manager_product_attribute'),
                        'url' => route('private-system.product-attribute'),
                        'url_name'=> 'product/attribute',
                        'icon' => '<i class="fa fa-archive"></i>',
                        // 'permission' => User::canPermissionCompetencyReport(),
                    ],
                    [
                        'name' => trans('admin.manager_brand'),
                        'url' => route('private-system.product-brand'),
                        'url_name'=> 'product/brand',
                        'icon' => '<i class="fa fa-archive"></i>',
                        // 'permission' => User::canPermissionCompetencyReport(),
                    ],
                ],
            ],
            'manager_promotions' => [
                'id' => 5,
                'name' => trans('admin.manager_promotion'),
                'url' => route('private-system.promotions.index'),
                'icon' => '<i class="fas fa-tachometer-alt"></i>',
                'url_name' => 'promotion',
                // 'url_item_child' => ['menus_cateloge','menus'],
                'item_childs' => [
                   
                ],
            ],
            'manager_order' => [
                'id' => 4,
                'name' => trans('admin.manager_order'),
                // 'url' => route('categories'),
                'url' => '',
                'is_open' => '',
                'url_name' => 'order',
                'icon' => '<i class="fas fa-suitcase"></i>',
                // 'permission' => ,
                'url_item_child' => ['product_family_info', 'product_family_create'],
                // 'item_childs' => [
                //     [
                //         'name' => trans('market.manager_sale_man_info'),
                //         'url' =>'',
                //         'icon' => 'fa fa-archive',
                //         // 'permission' => User::canPermissionCompetencyReport(),
                //     ],
                // ],
            ],
            'manager_slider' => [
                'id' => 12,
                'name' => trans('admin.manager_slider'),
                'url' => route('private-system.slider'),
                'is_open' => '',
                'url_name' => 'slider',
                'icon' => '<i class="fas fa-suitcase"></i>',
            ],
            'manager_widget' => [
                'id' => 15,
                'name' => trans('admin.manager_widget'),
                'url' => route('private-system.widget'),
                'is_open' => '',
                'url_name' => 'widget',
                'icon' => '<i class="fas fa-suitcase"></i>',
            ],
        ];
        $this->leftMenuBackend = $item;
        
        return $this->leftMenuBackend;
    }

}
