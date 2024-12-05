<?php

namespace App\Http\Controllers\Frontend\Ajax;

use App\Enums\Enum\StatusReponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Products\Entities\ProductCategory;
use Modules\Products\Entities\Products;
use Modules\Products\Entities\SkuVariants;
interface InterfaceAjax {
  public function getProductByCategoryParams(Request $request);
  public function getLoadVariantData(Request $request);
}
class ProductAjaxController extends Controller implements InterfaceAjax
{  
  public function getProductByCategoryParams(Request $request) {
      $productCategory = ProductCategory::where('id',$request->product_category_id)->first();
      if(!$productCategory){
          json_result(['message' => trans('admin.message_error'),'status' => StatusReponse::ERROR]);
      }
      $filter = $request->clear && $request->clear == 1 ? [] : array_map('intval',array_unique(array_merge(...array_values($request->attempt ?? []))));
      $type = $request->clear && $request->clear == 1 ? 'category' : 'filter';
      $arr = $productCategory->descendants->pluck('id')->toArray();
      $products = $this->getProductByCategory($request,$arr,$filter,$request->only(['price_lte','price_gte']),$type);
      
      if($products) {
        return response()->json(['rows' => $products , 'status' => StatusReponse::SUCCESS]);
      }
      return  response()->json(['rows' => [] , 'status' => StatusReponse::ERROR]);
  }

  public function getLoadVariantData(Request $request){
      if(!$request->attributeIndex || !$request->sku_code || !$request->sku_id || !$request->product_Id) {
        return response()->json(['message' => 'Có lỗi xảy ra','status' => StatusReponse::ERROR]);
      }
      $sku = $request->input('sku_code');
      $product_id = $request->input('product_Id');
      $sku_id = $request->input('sku_id');
      $sku_idxs = $request->input('attributeIndex') ? array_map('intval',$request->input('attributeIndex')) : [];
      if($sku_id){
        $query = SkuVariants::query();
        $query->select(['a.id','a.sku_code as sku','a.product_id','a.album','a.name','a.price','b.id as product_id','a.sku_idx','a.slug']);
        $query->from('sku_variants as a');
        $query->join('product as b','b.id','=','a.product_id');
        $query->where(function($subquery) use($sku_idxs,$product_id){
            $subquery->where('a.sku_idx',json_encode($sku_idxs));
            $subquery->where('b.id',$product_id);
        });
        $query->with('promotion');
        $model = $query->first();
        if($model) {
           $model->album = explode(',',$model->album);
           return response()->json([
              'message' => 'Thành công',
              'status' => StatusReponse::SUCCESS,
              'data' => $model
           ]);
        } 
        return response()->json(['message' => 'Có lỗi xảy ra','status' => StatusReponse::ERROR]); 
      } 
  }

 
  
}
