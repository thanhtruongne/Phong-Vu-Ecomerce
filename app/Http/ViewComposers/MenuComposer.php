<?php

namespace App\Http\ViewComposers;

use App\Models\Menu;
use App\Repositories\MenuCatelogeRepositories;
use Illuminate\View\View;

class MenuComposer {
    protected $language,$menuCatelogeRepositories;

    public function __construct($language , MenuCatelogeRepositories $menuCatelogeRepositories)
    {
        $this->language = $language;
        $this->menuCatelogeRepositories = $menuCatelogeRepositories;
    }
    /**
     * Bootstrap any application services.
     */
    public function compose(View $view)
    {
        $payload = $this->methodPassArgument($this->language);

        $menuCateloge = $this->menuCatelogeRepositories->findCondition(...$payload);
        $menusChild = renderMenuDynamicFrontEndChild(renderCombineMenu($menuCateloge->menu));
        $menusParent = renderMenuDynamicFrontEndParent(renderCombineMenu($menuCateloge->menu));
        $renderChild = explode('---',$menusChild); array_shift($renderChild);
        $renderParent = explode('---', $menusParent);
        $view->with('menus',array_merge(['parent' => $renderParent , 'child' => $renderChild]));
        
    }

    private function methodPassArgument($language_id) {
        return [
            'condition' => [
                ['keyword' , '=' , 'main-item']
            ],
            'params' => [],
            'relation' => [
                'menu' => function($query) use($language_id) {
                   $query->with([
                    'languages' => function($query) use($language_id) {
                           $query->where('language_id','=',$language_id);
                    }]);
                }
            ],
            'type' => 'first'
        ];
    }
}
