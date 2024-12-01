<?php

namespace App\Http\Controllers\Frontend\Ajax;

use App\Enums\Enum\StatusReponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Products\Entities\ProductCategory;

class ProductAjaxController extends Controller implements InterfaceAjax
{  
  public function getProductByCategoryParams(Request $request) {
    $productCategory = ProductCategory::where('id',$request->product_category_id)->first();
    if(!$productCategory){
        json_result(['message' => trans('admin.message_error'),'status' => StatusReponse::ERROR]);
    }
    $filter = $request->clear && $request->clear == 1 ? [] : array_map('intval',array_unique(array_merge(...array_values($request->attempt ?? []))));
    $type = $request->clear && $request->clear == 1 ? 'category' : 'filter';
  
    $products = $this->getProductByCategory($request,$productCategory,$filter,$request->only(['price_lte','price_gte']),$type);
    
    if($products) {
      return response()->json(['rows' => $products , 'status' => StatusReponse::SUCCESS]);
    }
    return  response()->json(['rows' => [] , 'status' => StatusReponse::ERROR]);
  }
  
}
