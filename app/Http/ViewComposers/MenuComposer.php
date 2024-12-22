<?php

namespace App\Http\ViewComposers;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Menu;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class MenuComposer extends Controller{
    protected $menu;

    public function __construct()
    {
        $this->menu();
    }
    /**
     * Bootstrap any application services.
     */
    public function compose(View $view)
    {
        // $this->menu();
         
        // $payload = $this->methodPassArgument();

        // $menuCateloge = $this->menuCatelogeRepositories->findCondition(...$payload);
        // $render = renderMenuDynamicFrontEndChild(renderCombineMenu($menuCateloge->menu ?? [])) ?? [];
        // $menusParent = renderMenuDynamicFrontEndParent(renderCombineMenu($menuCateloge->menu));
        // $renderChild = explode('---',$menusChild); array_shift($renderChild);
        // $renderParent = explode('---', $menusParent);
        
        // $view->with('menus',array_merge(['parent' => $renderParent , 'child' => $renderChild]));
        $view->with('menus',$this->menu());
    }

    private function menu(){
    //    $menus = Categories::whereNotNull('name')->get()->toTree()->toArray();
       $data = Cache::rememberForever('categories',function(){
            $menus =  Categories::whereNotNull('name')->get()->toTree()->toArray();
            return $this->rebuildTree($menus);
       });
    //    $data = $this->rebuildTree($menus);
       $render = renderMenuDynamicFrontEndChild($data);
       $renderChild = explode('---',$render);
       array_shift($renderChild);
       $renderParent = renderMenuDynamicFrontEndParent($data);
       $renderParent = explode('---', $renderParent);

        $data= [
            'child' => $renderChild,
            'parent' => $renderParent
        ];
       $this->menu = $data;
       return $this->menu;
    }


}
