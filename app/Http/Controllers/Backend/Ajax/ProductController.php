<?php

namespace App\Http\Controllers\Backend\Ajax;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\PromotionRepositoriesInterfaces as  PromotionRepositories;
use App\Repositories\ProductVariantsRepositories;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller

{
   protected $productVariantRepositories,$promotionRepositories;

   public function __construct(
        ProductVariantsRepositories $productVariantRepositories,
        PromotionRepositories $promotionRepositories
    )
   {
        $this->productVariantRepositories = $productVariantRepositories;
        $this->promotionRepositories = $promotionRepositories;
   }
  
   // load variant
   public function loadProductVariant(Request $request) {
      $data = $request->input();
      
      sort($data['attributeID'],SORT_NUMERIC);
      $productVariant = $this->productVariantRepositories->findProductVariant(...$data);
      if( !is_null($productVariant) && $productVariant->id > 0) {
         $productVariant->promotions = $this->promotionRepositories->getProductVariantPromotion([$productVariant->id ?? 0]);
         // $string_name_convert_wrapper = '('.explode(', ',$productVariant->name).')';
         return response()->json([
           'data' => $productVariant,
           'name_convert' => $productVariant->name
         ]);
      }
         return response()->json([
            'message' => 'Lỗi ứng dụng',
            'errCode' => -2
         ]);
    
   }
   



}
