<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\RecomenderSystem\ProductSimilarity;
use App\Repositories\AttributeCatelogeRepositories;
use App\Repositories\ProductCatelogeRepositories;
use App\Repositories\ProductRepositories;
use App\Repositories\ProductVariantsRepositories;
use App\Repositories\PromotionRepositories;
use App\Services\Interfaces\ProductServiceInterfaces as  ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redis;

class ProductController extends BaseController
{  
    protected $productService,
    $productRepositories,
    $productCatelogeRepositories,
    $promotionRepositories,
    $attributeCatelogeRepositories,
    $productVariantsRepositories;
   
    // protected $language;
    public function __construct(
        ProductService $productService,
        PromotionRepositories $promotionRepositories,
        AttributeCatelogeRepositories $attributeCatelogeRepositories,
        ProductVariantsRepositories $productVariantsRepositories,
        ProductRepositories $productRepositories,
        ProductCatelogeRepositories $productCatelogeRepositories
    )
   {
     $this->productService = $productService;
     $this->promotionRepositories = $promotionRepositories;
     $this->productVariantsRepositories = $productVariantsRepositories;
     $this->attributeCatelogeRepositories = $attributeCatelogeRepositories;
     $this->productRepositories = $productRepositories;
     $this->productCatelogeRepositories = $productCatelogeRepositories;
     parent::__construct();
   }
   
   public function index($id ,$request , $slug = null) {
      $config = [
          'js' => [
            'frontend/js/library/custom.js'
          ],
      ];

      if(!is_null($slug))  $slug = explode('--',$slug);

      $product = $this->productRepositories->getProductById($id);
      $conditionCheck = '';
      // dd($product);
      foreach($product->product_variant->pluck('sku')->toArray() as $check) {
        if($check == $request->input('sku')) $conditionCheck = $check;
      }
      //variant
      $variant = $this->productVariantsRepositories->getVariantSkuProduct($conditionCheck,implode(', ',$slug),$product->id);
      if(is_null($variant)) abort(404);
      if($variant->variant_id > 0) $variant->promotions = $this->promotionRepositories->getProductVariantPromotion([$variant->variant_id]);
      //check params 
      $this->checkParamsVariant($variant,$slug);
    
      
      $option = $this->getBreadCrumbsProductDetail($product);
      //breadcrumb tạm
      // $breadcrumbs =  $this->convertFillCateloge($product->product_cateloge_product);
     
      $attribute = [];
       // các variant attribute
      if(!is_null($product->attribute) && !is_null($product->attributeCateloge) && !is_null($product->variant)) {
        $attribute = $this->productService->getAttribute($product);
        
      }    
      
      $system = json_decode(Redis::get('system'),true);
      $Seo = [
            'title' => $system['seo_meta_title'],
            'desc' => $system['seo_meta_desc'],
            'keyword' => $system['seo_meta_keyword'],
            'image' => $system['seo_meta_images'],
            'canonical' => config('apps.apps.url')
      ];
      return view('Frontend.page.products.product.detail',
      compact('product','Seo','attribute','config','slug','variant','option'));
   }


   private function getBreadCrumbsProductDetail($product) {
          //lấy các danh mục thuộc sản phẩm
          $prouct_cateloge_id = $product->product_cateloge_product->pluck('id')->toArray();
          $productCateloges = $this->productCatelogeRepositories->findCondition([
            ['status','=',1]
          ],[
            'whereIn' => 'id',
            'whereValues' => $prouct_cateloge_id
          ],[],'multiple',[]);


          $cateloge = [];
          $id_product_related = [];
          if(!empty($product->product_cateloge_product) && isset($product->product_cateloge_product)) {
            // dd($productCateloges);
              $count = 1;
                foreach($productCateloges as $key => $productCateloge) {
                    $id_product_related[] = $productCateloge->products->pluck('id');
                    $cateloge[$count++] = $productCateloge->toArray();
                }
                if(!empty($this->productCatelogeRepositories->getParentAncestorsOf($cateloge[1]['id']))){
                  $cateloge['parent'] = $this->productCatelogeRepositories->getParentAncestorsOf($cateloge[1]['id'])
                 ->first()->toArray();              }
                }  
          //sản phẩm liên quan và promotions
          $product_related = $this->productRepositories->findCondition([
            ['status','=',1]
            ],[
            'whereIn' => 'id',
            'whereValues' => end($id_product_related)->toArray()
            ],[],'multiple',[]);
            foreach($product_related as $related) {
                $related->promotions = $this->promotionRepositories->findByProductPromotion([$related->id]);
                $product_variant_id = $related->product_variant->pluck('id')->toArray(); 
                $related->variant = $this->productService->CombineArrayProductHavePromotionByWhereIn($product_variant_id,$related->product_variant,'variant'); 
            }
  

            return [
              'product_related' =>  $product_related,
              'cateloge' => $cateloge
            ];
   }

  //  private function convertFillCateloge($product_cateloge){
  //    $nestedSetID = $product_cateloge->pluck('id')->toArray();
  //   //  dd($nestedSetID,$product_cateloge);
  //   $children = '';$data = [];
  //     foreach($product_cateloge as $key => $item){
  //         if(in_array($item->parent,$nestedSetID)){
  //            $children = $item;
  //         }
  //         else {
  //           $item->children = $children;
  //           $data = $item;
  //         }
  //     }
  //     $parent = $this->productCatelogeRepositories->getParentAncestorsOf($data->id);
  //     if(!empty($parent) && count($parent) == 1){
  //         $parent->first()->children = $data;
  //         // $parent['children'] = $data->toArray();
  //         return $parent;
        
  //     }
  //     return $data;
  //  }

   private function checkParamsVariant($variant,$slug) {
     $flag = strcmp(Str::slug(implode(', ',$slug)),Str::slug($variant->name));
     return $flag == 0 ? true : abort(404);
   }
   
}
