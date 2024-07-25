<?php

namespace App\Http\Controllers\Frontend\Ajax;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderStore;
use App\Models\Province;
use App\Repositories\OrderRepositories;
use App\Repositories\SliderRepositories;
use App\Repositories\SystemRepositories;
use App\Services\Interfaces\CartServiceInterfaces as CartService;
use App\Services\Interfaces\WidgetServiceInterfaces as  WidgetService;
use App\Services\ProductService;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
class ProductAjaxController
{  
    protected $orderRepositories;
    
    public function getProductAjax(Request $request){
        $model = $request->input('model') ?? 'Product';
        $page = ($request->input('page')) ? $request->input('page') : 1;
       
        $repositoriesName = 'App\Repositories\\'.ucfirst($model).'Repositories';
        if(class_exists($repositoriesName)) {
            $instanceRepositories = app($repositoriesName);
        }
        $payload = $this->conditionMenu(Str::snake($model) , $page);

        $data = $instanceRepositories->paganation(...array_values($payload));
        return response()->json(['response' => $data]);;
    }

    private function conditionMenu(string $model = '' , $page ):array {
    
        if(strpos($model,'_cateloge') == false) {
            $join[] =  [''.$model.'_cateloge_'.$model.' as pcsp','pcsp.'.$model.'_id','=',''.$model.'.id'];
        }
         return [
            'select' => ['canonical','name','id'],
            'condition' => [
                'record' => $page,
                ['status','','=', 1],
                
            ],
            'join' => $join ?? [] ,
            'page' => 8,
            'groupBy' => [],
            'extend' => [],
            'order' => ['id' => 'desc'],
            'whereRaw' => []
        ];
    
      }
  
}
