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
    $variant = null;$attribute = [];
      $config = [
          'js' => [
            'frontend/js/library/custom.js'
          ],
      ];

    

      $product = $this->productRepositories->getProductById($id);
      $conditionCheck = '';
      // dd($product);
      if(count($product->product_variant) > 0) {
        foreach($product->product_variant->pluck('sku')->toArray() as $check) {
          if($check == $request->input('sku')) $conditionCheck = $check;
        }
      } 
      //variant
      if(!is_null($slug)) {
        $slug = explode('--',$slug);
        $variant = $this->productVariantsRepositories->getVariantSkuProduct($conditionCheck,implode(', ',$slug),$product->id);
      }
      // if(is_null($variant)) abort(404);
      

      if(isset($variant) && !empty($variant) &&  $variant->variant_id > 0){
        $variant->promotions = $this->promotionRepositories->getProductVariantPromotion([$variant->variant_id]);
        //check params 
        $this->checkParamsVariant($variant,$slug);
        if(!is_null($product->attribute) && !is_null($product->attributeCateloge) && !is_null($product->variant)) {    
          // các variant attribute
          $attribute = $this->productService->getAttribute($product);       
        }  
      }
     
    
      
      $option = $this->getBreadCrumbsProductDetail($product);
      
      //breadcrumb tạm
      // $breadcrumbs =  $this->convertFillCateloge($product->product_cateloge_product);

      
      
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
       
          // dd($prouct_cateloge_id,$productCateloges,$product->product_cateloge_product);

          $cateloge = [];
          $id_product_related = [];
          if(!empty($product->product_cateloge_product) && isset($product->product_cateloge_product)) {
            // dd($productCateloges);
              $count = 1;
                foreach($productCateloges as $key => $productCateloge) {
                    $id_product_related[] = $productCateloge->products->pluck('id');
                    $cateloge[$count++] = $productCateloge->toArray();
                }
            
                if(!empty($this->productCatelogeRepositories->getParentAncestorsOf($cateloge[1]['id'])) 
                && count($this->productCatelogeRepositories->getParentAncestorsOf($cateloge[1]['id'])) > 0){
                  $cateloge['parent'] = $this->productCatelogeRepositories->getParentAncestorsOf($cateloge[1]['id'])
                 ->first()->toArray();              
                }
          }  
          $product_related = $this->getProductRelatedVariant($productCateloges->pluck('id')->toArray());
          

            return [
              'product_related' =>  $product_related,
              'cateloge' => $cateloge
            ];
   }

   private function selectProductPerformance(){
      return ['name','image','code_product','id','attribute','variant','attributeCateloge',
      'canonical','price','content'];
   }

   private function getProductRelatedVariant(array $id = []){
   
      $product_related = $this->productRepositories->getProductByProductCatelogeID($id);
      foreach($product_related as $related) {

       
        if(!empty($related->product_variant) && count($related->product_variant) > 0) {
          // $product_related = $this->CombineArrayProductHavePromotionByWhereIn($product_related->pluck('product_variant_id')->toArray(),$product_related,'product');
          $product_variant_id = $related->product_variant->pluck('id')->toArray();              
          $related->variant = $this->productService->CombineArrayProductHavePromotionByWhereIn($product_variant_id,$related->product_variant,'variant'); 
        }
        else {
          $related->promotions = $this->promotionRepositories->findByProductPromotion([$related->id]);
        }
        // $product_related = $this->createCanonicalDynamic($product_related);
        
      }
      return $product_related;
   }

   private function checkParamsVariant($variant,$slug) {
     $flag = strcmp(Str::slug(implode(', ',$slug)),Str::slug($variant->name));
     return $flag == 0 ? true : abort(404);
   }
   private function combinePromotionAccess(array $id = [] , $products) {
    $promotions = $this->promotionRepositories->getProductVariantPromotion($id);
    foreach($products as $key => $product) {
       
        foreach($promotions as $index => $promo) {
            if($promo['product_variant_id'] === $product->product_variant_id) {
               $products[$index]->promotions = $promo;   
            
        }
    }
    return $products;
    }
}
private function createCanonicalDynamic($products) {
    foreach($products as $product){
        $name_slug = [];
        $nameCanonical = explode(', ',$product->product_variant_name);
        foreach($nameCanonical as $variant) {
            $name_slug[] = Str::slug($variant);
        };
        $product_price_after_discount = 0;
        if(!empty($product->promotions)) {     
            $product_price_after_discount = 
            $product->promotions['product_variant_price'] - $product->promotions['discount'] ;                       
        }
        $product->price_update = $product_price_after_discount != 0 ? $product_price_after_discount : $product->price;
        $url = $product->product_canonical.'---'.implode('--',$name_slug).'?sku='.$product->sku;
        $product->canonical = makeTheURL($url,true);
      
    }
    return $products;
}
   
}
