<?php

namespace App\Http\Controllers\Backend\Ajax;

use App\Http\Controllers\Controller;
use App\Repositories\ProductCatelogeRepositories;
use App\Repositories\ProductRepositories;
use App\Repositories\PromotionRepositories;
use Illuminate\Http\Request;

class AjaxPromotionController extends Controller
{
  protected $productRepositories , $productCatelogeRepositories,$promotionRepositories;

  public function __construct(
    ProductRepositories $productRepositories,
    ProductCatelogeRepositories $productCatelogeRepositories,
    PromotionRepositories $promotionRepositories) 
    {
        $this->productCatelogeRepositories = $productCatelogeRepositories;
        $this->productRepositories = $productRepositories;
        $this->promotionRepositories = $promotionRepositories;
    }

  public function loadPromotion(Request $request) 
  {
    $modelType = $request->input('model');

    if($modelType == 'ProductCateloge') {
      $condition['original'] = [
        ['status','=',1]
      ];
      if(!empty($request->input('keyword'))) {
        $condition['keyword'] = 
        [
            ['name','like','%'.$request->input('keyword').'%'],
        ];
      }
      $data =  $this->productCatelogeRepositories->getProductCatelogePromotion($condition , [] );
      return $data;
    }
    else if($modelType == 'Product') {
      $condition['original'] = [
        ['product.status','=',1]
      ];
      if(!empty($request->input('keyword'))) {
        $condition['keyword'] = 
        [
            ['product.name','like','%'.$request->input('keyword').'%'],
            ['pv2.sku','=',$request->input('keyword')],
            ['pv2.barcode','=',$request->input('keyword')],
        ];
        
      }
      $data =  $this->productRepositories->FindByPromotionProduct($condition,[]);
      return $data;
    }

  }

  public function getInterview(Request $request) {
    $id = $request->input('id');
    $promotion = $this->promotionRepositories->findByid($id);
    $data = [];
    foreach($promotion->products as $key  => $item) {
       $data[] = [
        'name' => $item->name,
        'id' => $item->pivot->product_id,
        'variant_id' => $item->pivot->product_variant_id,
        'checked' => $item->pivot->product_id.'_'.$item->pivot->product_variant_id
       ];
    }
    return $data;
    
  }


}
