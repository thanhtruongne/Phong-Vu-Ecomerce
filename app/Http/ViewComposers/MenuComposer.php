<?php

namespace App\Http\ViewComposers;

use App\Models\Menu;
use App\Repositories\MenuCatelogeRepositories;
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
        $payload = $this->methodPassArgument();

        $menuCateloge = $this->menuCatelogeRepositories->findCondition(...$payload);
        $menusChild = renderMenuDynamicFrontEndChild(renderCombineMenu($menuCateloge->menu ?? [])) ?? [];
        $menusParent = renderMenuDynamicFrontEndParent(renderCombineMenu($menuCateloge->menu));
        $renderChild = explode('---',$menusChild); array_shift($renderChild);
        $renderParent = explode('---', $menusParent);
        
        $view->with('menus',array_merge(['parent' => $renderParent , 'child' => $renderChild]));
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
