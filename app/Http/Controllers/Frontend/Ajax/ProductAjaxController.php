<?php

namespace App\Http\Controllers\Frontend\Ajax;

use App\Repositories\AttributeCatelogeRepositories;
use App\Repositories\ProductRepositories;
use App\Repositories\PromotionRepositories;
use App\Services\Interfaces\ProductCatelogeServiceInterfaces as ProductCatelogeService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class ProductAjaxController
{  
    protected $orderRepositories,$productRepositories,$attributeCatelogeRepositories,$productCatelogeService,$promotionRepositories;

    public function __construct(
        AttributeCatelogeRepositories $attributeCatelogeRepositories,
        ProductRepositories $productRepositories,
        ProductCatelogeService $productCatelogeService,
        PromotionRepositories $promotionRepositories,
        )
    {
        $this->attributeCatelogeRepositories = $attributeCatelogeRepositories;
        $this->productCatelogeService = $productCatelogeService;
        $this->promotionRepositories = $promotionRepositories;
        $this->productRepositories = $productRepositories;
    }
    
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


    public function filterProductCatelogeFE(Request $request) {
        $data = $request->all();
        $filedAttribute = [];
        
       $fillAttriubteCateloge = $this->attributeCatelogeRepositories->AllCateloge(['name','parent','id','LEFT','RIGHT']);
       if(count($fillAttriubteCateloge) > 0) {
            foreach($fillAttriubteCateloge as $payload) {
                if(array_key_exists(convert_string_slug_trim($payload->name),$data)){
                     $filedAttribute[] = explode(',',$data[convert_string_slug_trim($payload->name)]);
                }
            }
       }   
        $products = $this->productRepositories->findProductByFilterDynamic($filedAttribute,$data);
        if(count($products) > 0) {
            $products = $this->createCanonicalDynamic($products);
            $products = $this->combinePromotionAccess($products->pluck('product_variant_id')->toArray(),$products);
        }
        return response()->json(['data' => $products,'message' => 'success','status' => true]);
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