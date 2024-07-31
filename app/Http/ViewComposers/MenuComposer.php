<?php

namespace App\Http\ViewComposers;

use App\Models\Menu;
use App\Repositories\MenuCatelogeRepositories;
use Illuminate\Support\Facades\Redis;
use Illuminate\View\View;

class MenuComposer {
    protected $menuCatelogeRepositories;

    public function __construct(MenuCatelogeRepositories $menuCatelogeRepositories)
    {
        $this->menuCatelogeRepositories = $menuCatelogeRepositories;
    }
    /**
     * Bootstrap any application services.
     */
    public function compose(View $view)
    {
        
        if(!Redis::get('menus')) {
            $payload = $this->methodPassArgument();
            $menuCateloge = $this->menuCatelogeRepositories->findCondition(...$payload);
            $menusChild = renderMenuDynamicFrontEndChild(renderCombineMenu($menuCateloge->menu ?? [])) ?? [];
            $menusParent = renderMenuDynamicFrontEndParent(renderCombineMenu($menuCateloge->menu));
            $renderChild = explode('---',$menusChild); array_shift($renderChild);
            $renderParent = explode('---', $menusParent);
            Redis::set('menus',json_encode(array_merge(['parent' => $renderParent , 'child' => $renderChild])));
        } 
        $menus = Redis::get('menus');
        $view->with('menus',json_decode($menus,true));
    }

    private function methodPassArgument() {
        return [
            'condition' => [
                ['keyword' , '=' , 'main-item']
            ],
            'params' => [],
            'relation' => [
                'menu'             
            ],
            'type' => 'first'
        ];
    }
}
