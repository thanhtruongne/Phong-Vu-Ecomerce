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
        $view->with('menus',$this->menu());
    }

    private function menu(){
       $data = Cache::rememberForever('categories',function(){
            $menus =  Categories::whereNotNull('name')->get()->toTree()->toArray();
            $sum = $this->rebuildTree($menus);
            $render = renderMenuDynamicFrontEndChild($sum);
            $renderChild = explode('---',$render);
            array_shift($renderChild);
            $renderParent = renderMenuDynamicFrontEndParent($sum);
            $renderParent = explode('---', $renderParent);

             $temp = [
                 'child' => $renderChild,
                 'parent' => $renderParent
             ];
            return $temp;
       });
       $this->menu = $data;
       return $this->menu;
    }


}
