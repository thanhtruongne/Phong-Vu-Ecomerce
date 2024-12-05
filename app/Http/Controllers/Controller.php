<?php

namespace App\Http\Controllers;

use App\Enums\Enum\StatusReponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Modules\Products\Entities\Attribute;
use Modules\Products\Entities\SkuVariants;
use Modules\Products\Entities\Products;
use Modules\Promotions\Entities\Promotions;


abstract class ControllerAstract {
    protected function selectQueryDynamic(string $type): array{
        if($type && $type == 'variant') {
          return ['a.id','a.name','a.sku_code','a.slug','a.price','a.album','a.product_id',\DB::raw('UPPER(b.name) as brand_name')];
        } elseif($type && $type == 'product'){
          return ['a.id','a.name','a.sku_code','a.product_category_id','a.image','a.price',\DB::raw('UPPER(b.name) as brand_name'),'a.quantity'];
        }
        else return [];
    }
    protected function getRelationMade(string $type): array {
        if($type && $type == 'variant') {
            return ['promotion','product'];
        } elseif($type && $type == 'product'){
            return ['promotion','product_category'];
        }
        else return [];
    }


    protected function handleMadeClass(string $app = '',string $model = '',string $type = 'App') {
        $namespace = '';
        if($type && $type != 'App' && $type == 'Modules') {
            $nameSpace = "\Modules\\".$app.'\\'.'Entities'.'\\'.ucfirst($model);
        }else {
            $nameSpace = "\App\\".$app.'\\'.ucfirst($model);
        }
        if(class_exists($nameSpace)) {
           $instance = app($nameSpace);
        }
        return $instance;
    }
} 

interface ControllerInterfaces{
    public function validateRequest($rules, Request $request, $attributeNames = null);
    public function rebuildTree($data,$parent_id = 0);
    public function getProductsHome(string $type = null);
    public function getWidgetData($widgets);
    public function getFilterProductCategory($products);
    public function getProductDetailByRequest(string $url , string $slug);
}

class Controller extends ControllerAstract implements ControllerInterfaces
{
    use AuthorizesRequests, ValidatesRequests;

    public function validateRequest($rules, Request $request, $attributeNames = null)
    {
        $validator = \Validator::make($request->all(), $rules);
        if ($attributeNames) {
            $validator->setAttributeNames($attributeNames);
        }
         
        if ($validator->fails()) {
            json_result(['message' => $validator->errors()->all()[0],'status' => StatusReponse::ERROR]);
        }
    }

    public function rebuildTree($data,$parent_id = 0){
        if(isset($data) && count($data) > 0){
            foreach($data as $key => $children){
                $sum[] = [
                    'name' => $children['name'],
                    'value' => $children['id'],
                    'children' => count($children['children']) > 0 ? $this->rebuildTree($children['children'],$children['id']) : []
                ];
            }
             
            return  $sum;
        }
    }

    public function getProductsHome(string $type = null){
        $query = Products::query();
        $query->select(['a.id','a.brand_id','a.sku_code as product_sku','a.name as product_name','c.album as variant_album','c.name as variant_name','c.price as variant_price','c.sku_code as variant_sku','c.stock as variant_stock','c.id as variant_id','a.image','a.price','a.quantity','b.name as category_name',
        \DB::raw('UPPER(e.name) as brand_name')]);
        $query->from('product as a');
        $query->join('product_category as b','b.id','=','a.product_category_id');
        $query->join('brand as e','e.id','=','a.brand_id');
        $query->leftJoin('sku_variants as c','c.product_id','=','a.id');    
        $query->where('a.status',1);
        // if($type && $type == 'self') {
        //     $id = auth()->check() ? auth()->id() : session()->getId();
        //     $user_key = 'user_or_guest_viewed_product_'.$id;
        //     if(cache()->has($user_key)){
        //         $data = cache()->get('')
        //     }
        // }
        $query->with('promotion');
        $rows =  $query->paginate(10);
        foreach($rows as $row) {
            if($row->variant_id) {
                $row->variant_album = explode(',',json_decode($row->variant_album))[0];
                // $row->promotion
                $promo_id = \DB::table('promotion_variants_relation')->where('sku_id',$row->variant_id)->value('promotion_id');
                $row->variant_promotion_price = [
                    'promo_id' => $promo_id,
                    'amount' => Promotions::where('id',$promo_id)->value('amount'),
                ]; 
            }
        }
        return $rows;
    }

    public function getWidgetData($widgets) {
        $data = [];
        foreach($widgets as $index => $widget) {
            if($widget->model_id && $widget->keyword) {
                $item = [];
                foreach($widget->model_id as $index => $value) {
                    $instance = $this->handleMadeClass('Products',$value && $value['type'] == 'variant' ? 'SkuVariants' : 'Products','Modules');
                    $slug = $value && $value['type'] == 'variant' ? "sku_variants" : "product";
                    $model = $instance::query();
                    $model->from($slug.' as a');
                    $model->select($this->selectQueryDynamic($value['type']));
                    
                    if($instance && $value['type'] == 'product') {
                        $model->join('brand as b','b.id','=','a.brand_id');
                        $model->leftJoin('promotion_product_relation as promo_data','promo_data.product_id','=','a.id');
                    } else {
                        $model->join('product as c','c.id','=','a.product_id');
                        $model->join('brand as b','b.id','=','c.brand_id');
                        $model->leftJoin('promotion_variants_relation as promo_data','promo_data.sku_id','=','a.id');
                    }
                    $model->leftJoin('promotions as promo','promo.id','=','promo_data.promotion_id');
                    $model->where(function($subquery){           
                         $subquery->whereRaw('(promo.neverEndDate IS NULL AND promo.endDate > ?)',[\Carbon::now()]);
                         $subquery->orWhere('promo.neverEndDate',1);
                         $subquery->where('promo.status',1);
                    });
                    $model->where('a.sku_code',$value['sku']);
                    $model->with($this->getRelationMade($value['type']));
                    $row =  $model->first();
                    if($row)
                        $item[] = $row;
                }
                $widget->data = $item;
            }
        }
        return $widgets;
    }

public function getProductByCategory(Request $request,array $productCategory = [],array $filter = [],$range_price = null,$type = 'category') {
        $limit = $request->input('limit',20);
        $offset = $request->input('offset',0);


        $query = Products::query();
        $query->select(['a.id','a.slug','a.brand_id','a.sku_code as product_sku',
        'a.name as product_name','c.album as variant_album','c.name as variant_name',
        'c.price as variant_price','c.slug as variant_slug','c.sku_code as variant_sku','c.stock as variant_stock','a.attributes',
        'c.id as sku_id','a.image','a.price','a.quantity','a.product_category_id',
        \DB::raw('UPPER(b.name) as brand_name')]);
        $query->from('product as a');
        $query->join('brand as b','b.id','=','a.brand_id');
        $query->leftJoin('sku_variants as c','c.product_id','=','a.id');
        $query->whereIn('a.product_category_id',$productCategory);
        if($type != 'category' && $type == 'filter'){
            if(isset($filter) && !empty($filter)){
                $query->leftJoin('product_attribute_relation as par','par.product_id','=','a.id');
                $query->whereIn('par.attribute_id',$filter);
            }
            if(isset($range_price['price_lte']) || isset($range_price['price_gte'])) {
                $price_lte = isset($range_price['price_lte']) ? $range_price['price_lte'] : null;
                $price_gte = isset($range_price['price_gte']) ?  $range_price['price_gte'] : null;
                if($price_lte && $price_gte){
                    $query->whereBetween('a.price',[$price_gte,$price_lte]);
                    $query->orWhereBetween('c.price',[$price_gte,$price_lte]);
                } elseif($price_lte){
                    $query->where('a.price','<=',$price_lte);
                    $query->orWhere('c.price','<=',$price_lte);
                } elseif($price_gte){
                    $query->where('a.price','>=',$price_gte);
                    $query->orWhere('c.price','>=',$price_gte);
                }
            }
        }
        // $query->where('a.status',1);
        $query->with(['promotion','attributes_item']);
        $query->distinct();
        $query->offset($offset);
        $query->limit($limit);
        $products = $query->get();
        if(!empty($products)) {
            foreach($products as $product) {
                if($product->sku_id){
                    $product->variant_album = explode(',',json_decode($product->variant_album))[0];
                    // $product->promotion
                    $promo_id = \DB::table('promotion_variants_relation')->where('sku_id',$product->sku_id)->value('promotion_id');
                    $product->variant_promotion_price = [
                        'promo_id' => $promo_id,
                        'amount' => Promotions::where('id',$promo_id)->value('amount'),
                    ]; 
                }
            }
        }
        return $products;

    }

    public function getProductDetailByRequest(string $url,string $sku){
        $query = Products::query();
        $query->select(['a.id','a.product_category_id','a.description','a.content','a.slug','a.brand_id','a.sku_code as product_sku',
        'a.name as product_name','c.album as variant_album','c.name as variant_name',
        'c.price as variant_price','c.slug as variant_slug','c.sku_code as variant_sku',
        'c.stock as variant_stock','a.attributes','c.sku_idx',
        'c.id as sku_id','a.image','a.price','a.album',
        \DB::raw('UPPER(b.name) as brand_name')]);
        $query->from('product as a');
        $query->join('brand as b','b.id','=','a.brand_id');
        $query->leftJoin('sku_variants as c','c.product_id','=','a.id');
        $query->where(function($query) use($url,$sku){
          $query->where('a.slug',$url);
          $query->orWhere('c.slug',$url);
          $query->where('a.sku_code',$sku);
          $query->orWhere('c.sku_code',$sku);
        });
        $query->where('a.status',1);
        $query->with(['promotion','attributes_item']);
        $product = $query->first();
        if($product && $product->sku_id){
            // $product->variant_album = explode(',',json_decode($product->variant_album))[0];
            // $product->promotion
            $product->variant_image = explode(',',json_decode( $product->variant_album))[0];

            $promo_id = \DB::table('promotion_variants_relation')->where('sku_id',$product->sku_id)->value('promotion_id');
            $promo_value = Promotions::where('id',$promo_id)->first(['amount','name']);
            $product->variant_promotion_price = [
                'promo_id' => $promo_id,
                'amount' => $promo_value->amount,
                'name' => $promo_value->name,
            ]; 

            // variant
            $data = [];
            $arr_check = $product->attributes_item->pluck('id')->toArray();
            $count = 0;
            foreach($product->attributes as $key => $attirbute_products) {
                $item = [];
                foreach($attirbute_products as $attempt) {
                    if(in_array($attempt,$arr_check)) {
                        $item[] = [
                            'name' => Attribute::where('id',$attempt)->value('name'),
                            'id' => $attempt
                        ];
                    }
                }
                $key_name = Attribute::where('id',$key)->value('name') . '_'.$count;
                $data[$key_name] = $item;
                $count++;
            };
            if($data) 
                $product->attribute_variant = $data;
        }
        return $product;
    }

    public function getFilterProductCategory($products){    
        if(isset($products) && !empty($products)) {
            $attemp_product = [];$attemp_variant = [];
             foreach($products as $product) {
                if($product->sku_id && $product->attributes){
                   array_push($attemp_variant,$product->attributes);
                } else {
                   array_push($attemp_product,$product->attributes_item->pluck('id','parent_id')->toArray());
                }
            }
            if($attemp_product || $attemp_variant) {
                // dd($attemp_product,$attemp_variant);
               $data = $this->createAttempProductAttributes(array_merge($attemp_product,$attemp_variant));
               if($data)
                    return $data;
            }
            return null;
        }
        return null;
    }
    private function createAttempProductAttributes(array $data):array{
        $result = [];
        $filters = [];
        foreach($data as  $values) {
            foreach($values as $key => $value) {
                if (!isset($result[$key])) {
                    $result[$key] = [];
                }
                if(is_array($value)){
                    array_push($result[$key],...$value);
                } else {
                    $result[$key][] = $value;
                }
              
            }
        }
        if(!empty($result)) {
            foreach ($result as $index => $values) {
                if($array_check = array_unique($values)) {
                    $item = [];
                    foreach($array_check as $value) {
                        $name = Attribute::where(['id' => $value,'parent_id' => $index])->value('name');
                        $item[] = [
                            'name' => $name,
                            'id' => (int)$value,
                            'slug' => str_replace('-','',\Str::slug($name)),
                        ];
                    }
                    $parent_name = Attribute::where('id',$index)->value('name');
                    $filters[] = [
                        'id' => $index,
                        'name' => $parent_name,
                        'item' => $item,
                        'slug' => str_replace('-','',\Str::slug($parent_name)),
                    ];
                }
            }
            return $filters;
        }
        else return $filters;
        
    }

    protected function totalCart($carts) {
        $total = 0;
        foreach($carts as $item) {
           $price = $item->options->price_after_discount ? $item->options->price_after_discount : $item->price;
           $total +=  +$price* $item->qty;
        }
        return $total;
    }

}
