<?php

namespace App\Http\ViewComposers;
use Illuminate\View\View;

class LeftMenuComposer {
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
        // $payload = $this->methodPassArgument();

        // $menuCateloge = $this->menuCatelogeRepositories->findCondition(...$payload);
        // $menusChild = renderMenuDynamicFrontEndChild(renderCombineMenu($menuCateloge->menu ?? [])) ?? [];
        // $menusParent = renderMenuDynamicFrontEndParent(renderCombineMenu($menuCateloge->menu));
        // $renderChild = explode('---',$menusChild); array_shift($renderChild);
        // $renderParent = explode('---', $menusParent);
        
        // $view->with('menus',array_merge(['parent' => $renderParent , 'child' => $renderChild]));
        $view->with('leftMenuBackend',$this->leftMenuComposer());
    }
    
    public function leftMenuComposer(){
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
            'manager_menus' => [
                'id' => 5,
                'name' => trans('admin.manager_menu'),
                'url' => '#',
                'is_open' => 1,
                'icon' => '<i class="fas fa-tachometer-alt"></i>',
                'url_name' => 'menu',
                'url_item_child' => ['menus_cateloge','menus'],
                'item_childs' => [
                    [
                        'name' => trans('admin.manager_menu'),
                        'url' =>route('private-system.product-cateloge'),
                        'url_name'=> 'menus',
                        'icon' => '<i class="fa fa-archive"></i>',
                        // 'permission' => User::canPermissionCompetencyReport(),
                    ],
                    [
                        'name' => trans('admin.manager_menu_cateloge'),
                        'url' => route('private-system.menus.cateloge.index'),
                        'url_name'=> 'menus/cateloge',
                        'icon' => '<i class="fa fa-archive"></i>',
                        // 'permission' => User::canPermissionCompetencyReport(),
                    ],
                ],
            ],
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
                        'name' => trans('admin.manager_product_categories'),
                        'url' =>route('private-system.product-cateloge'),
                        'url_name'=> 'manager-product-categories',
                        'icon' => '<i class="fa fa-archive"></i>',
                        // 'permission' => User::canPermissionCompetencyReport(),
                    ],
                    [
                        'name' => trans('admin.manager_product_attribute'),
                        'url' => route('private-system.product-attribute'),
                        'url_name'=> 'manager-product-attribute',
                        'icon' => '<i class="fa fa-archive"></i>',
                        // 'permission' => User::canPermissionCompetencyReport(),
                    ],
                    [
                        'name' => trans('admin.manager_product_item'),
                        'url' => route('private-system.product'),
                        'url_name'=> 'product',
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
            // 'categories' => [
            //     'id' => 4,
            //     'name' => trans('market.permission_role_manager'),
            //     // 'url' => route('categories'),
            //     'url' => '',
            //     'is_open' => '',
            //     'url_name' => 'permissions',
            //     'icon' => '<i class="fas fa-suitcase"></i>',
            //     // 'permission' => ,
            //     'url_item_child' => ['role', 'permissions'],
            //     'item_childs' => [
            //         [
            //             'name' => trans('market.permission_manager'),
            //             'url_name' =>'permissions',
            //             //  'url' => route('permission.index'),
            //              'url' => '',
            //           'icon' => '<i class="fas fa-suitcase"></i>',
            //             // 'permission' => User::canPermissionCompetencyReport(),
            //         ],
            //         [
            //             'name' => trans('market.role_manager'),
            //             'url_name' =>'permissions/role',
            //             //  'url' => route('categories'),
            //              'url' => '',
            //             'icon' => '<i class="fas fa-suitcase"></i>',
            //             // 'permission' => User::canPermissionCompetencyReport(),
            //         ],
            //     ],
            // ],
        ];
        $this->leftMenuBackend = $item;
        
        return $this->leftMenuBackend;
    }

}
