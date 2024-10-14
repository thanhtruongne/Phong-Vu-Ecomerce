<?php

namespace App\View\Components;

use App\Http\Controllers\Backend\CategoriesController;
use App\Models\Categories as ModelsCategories;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Modules\Products\Entities\ProductCateloge;

class Categories extends Component
{
    public $type;
    public $value;
    /**
     * Create a new component instance.
     */
    public function __construct($value = 0 ,string $type = '')
    {
        $this->type = $type;
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        if($this->type && $this->type == 'categories')
            $categories =  ModelsCategories::whereNotNull('name')->get()->toTree()->toArray();
        elseif($this->type == 'productCateloge')
            $categories =  ProductCateloge::whereNotNull('name')->get()->toTree()->toArray();
        
        $data = $this->rebuildTree($categories);
        return view('components.categories',['data' => $data , 'value' => $this->value]);
    }


    private function rebuildTree($categories , $parent_id = 0){
        if(isset($categories) && count($categories) > 0){
            foreach($categories as $key => $children){
                if($parent_id == $children['parent_id']){
                    $data[] = [
                       'name' => $children['name'],
                       'value' => $children['id'],
                       'children' => count($children['children']) ?  $this->rebuildTree($children['children'],$children['id']) : []
                   ];
                }
            }
             
            return  $data;
        }
    }
}
