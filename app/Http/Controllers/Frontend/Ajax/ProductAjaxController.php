<?php

namespace App\Http\Controllers\Frontend\Ajax;

use App\Enums\Enum\StatusReponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Products\Entities\ProductCategory;

class ProductAjaxController extends Controller implements InterfaceAjax
{  
    
    // public function getProductAjax(Request $request){
    //     $model = $request->input('model') ?? 'Product';
    //     $page = ($request->input('page')) ? $request->input('page') : 1;
       
    //     $repositoriesName = 'App\Repositories\\'.ucfirst($model).'Repositories';
    //     if(class_exists($repositoriesName)) {
    //         $instanceRepositories = app($repositoriesName);
    //     }
    //     $payload = $this->conditionMenu(Str::snake($model) , $page);

    //     $data = $instanceRepositories->paganation(...array_values($payload));
    //     return response()->json(['response' => $data]);;
    // }

    // private function conditionMenu(string $model = '' , $page ):array {
    
    //     if(strpos($model,'_cateloge') == false) {
    //         $join[] =  [''.$model.'_cateloge_'.$model.' as pcsp','pcsp.'.$model.'_id','=',''.$model.'.id'];
    //     }
    //      return [
    //         'select' => ['canonical','name','id'],
    //         'condition' => [
    //             'record' => $page,
    //             ['status','','=', 1],
                
    //         ],
    //         'join' => $join ?? [] ,
    //         'page' => 8,
    //         'groupBy' => [],
    //         'extend' => [],
    //         'order' => ['id' => 'desc'],
    //         'whereRaw' => []
    //     ];
    
    //   }


    public function getProductByCategoryParams(Request $request) {
      $productCategory = ProductCategory::where('id',$request->product_category_id)->first();
      if(!$productCategory){
         json_result(['message' => trans('admin.message_error'),'status' => StatusReponse::ERROR]);
      }
      $filter = array_map('intval',array_unique(array_merge(...array_values($request->attempt))));
      $products = $this->getProductByCategory($request,$productCategory,$filter,'filter');
      if($products) {
        return response()->json(['rows' => $products , 'status' => StatusReponse::SUCCESS]);
      }
      return  response()->json(['rows' => [] , 'status' => StatusReponse::ERROR]);
    }
  
}
