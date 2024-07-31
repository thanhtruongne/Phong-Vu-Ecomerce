<?php
namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoriesInterfaces;
use Illuminate\Support\Facades\DB;

 class ProductRepositories extends BaseRepositories implements ProductRepositoriesInterfaces  {
    
    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function getProductById($id) {
        return $this->model->select([
                            'id',
                            'image',
                            'status',
                            'album',
                            'product_cateloge_id',
                            'variant',
                            'attribute',
                            'attributeCateloge',
                            'code_product',
                            'form',
                            'price',
                            'name',
                            'content',
                            'desc',
                            'meta_title',
                            'meta_desc',
                            'meta_keyword',
                            'canonical',
                            ])
                            ->with([
                                'product_cataloge',
                                'product_variant' => function($query) {
                                   $query->with('attributes');
                                }
                            ])
                            ->find($id);
    }


    public function FindByPromotionProduct(array $condition = [], array $relation = []) {
        $query = $this->model->newQuery();
        $query->select([
            'product.image' ,
            'product.id' ,
            'pv2.id as variant_id',
            'pv2.sku',
            'pv2.price' ,
            'pv2.qualnity',  
            DB::raw('CONCAT(product.name,"-",COALESCE(pv2.name,"mặc định")) as variant_name_translate')
        ]);
        $query->leftJoin('product_variant as pv2','pv2.product_id', '=' ,'product.id');
        if(!isset($condition['keyword']) && empty($condition['keyword'])) {
            foreach($condition['original'] as $key => $item) { 
                $query->where($item[0],$item[1],$item[2]);
            }
        }   
   
        if(isset($condition['keyword']) && !empty($condition['keyword'])) {
            foreach($condition['original'] as $key => $item) { 
                foreach($condition['keyword'] as $key => $val) { 
                    $query->orWhere([
                        [$val[0],$val[1],$val[2]],
                        [$item[0],$item[1],$item[2]]
                    ]);
                }
            }
          
        }   
        if(!empty($relation)) {
            $query->with($relation);
        }
        return $query->paginate(4);
    }


    public function getoutStandingProduct(int $record = 4){
        return $this->model->orderBy('created_at','DESC')->paginate($record);
    }

    public function findProductByFilterDynamic($attribute , $payload) {
      
      if(!empty($attribute) && count($attribute) > 0) {
        $attributeVal = array_unique(array_merge(...$attribute));
      }
 
      return $this->model->select($this->selectDynamic())
      ->join('product_variant as pv','product.id','=','pv.product_id')
      ->join('product_cateloge as pc','pc.id','=','product.product_cateloge_id')
      ->WhereAttribute($attributeVal ?? [])
      ->WhereBrand(isset($payload['thuonghieu']) ?  explode(',',$payload['thuonghieu']) : [])
      ->whereBetWeenPrice(isset($payload['price_lte']) ?  $payload['price_lte'] : '',
       isset($payload['price_gte']) ?  $payload['price_gte'] : '')
      ->SortOrderProduct($payload['sort'] ?? '',$payload['order'] ?? '')
    //   ->toSql();
      ->get();
    }

    public function getProductByProductCatelogeID(array $id = []) {
  
        return $this->model->select($this->selectProductRelated())
        // ->join('product_variant as pv','product.id','=','pv.product_id')
        ->join('product_cateloge as pc','pc.id','=','product.product_cateloge_id')
        ->whereIn('pc.id',$id)
        ->with('product_variant')
        ->get();
    }
    
    private function selectProductRelated() {
        return ['product.name','product.id','product.image','pc.name as cateloge_name','product.price','product.code_product','product.canonical'];
    }

    // private function Dynamic
    
    private function selectDynamic() {
        return [
            DB::raw('CONCAT(product.name,"-",COALESCE(pv.name," ")) as name'),
            'product.name as product_name',
            'pv.name as product_variant_name',
            'pv.id as product_variant_id',
            'product.canonical as product_canonical',
            'pv.album',
            'pv.code',
            'pv.price',
            'pv.sku',
            'pv.qualnity',
            'pv.product_id as product_id',
            'pc.name as cateloge_name'
        ];
    }
 }