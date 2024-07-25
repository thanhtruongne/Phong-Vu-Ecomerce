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


    public function getProductVariantBySkuAndCode(string $sku = '',string $nameCode = '',int $id = 0,int $languages_id = 1) {
    //     // $product = $this->model->select($this->selectVariantSku())->with(
    //     //     [
    //     //     'product_variant' => function($query) use($sku,$languages_id) {
    //     //        $query->with(['languages' => function($query) use($languages_id) {
    //     //          $query->where('languages_id',$languages_id);
    //     //        }])->where('sku',$sku);
               
    //     //     }
    //     //     ]
    //     // )->find($id);



    //     // dd($product);
    //     return $this->model->select($this->selectVariantSku())
    //     ->join('product_variant as pv','pv.product_id','=','product.id')
    //     ->join('product_variant_translate as pvt','pvt.product_variant_id','=','product_variant.id')
    //     ->where('product_variant.sku',$sku)->where('product_variant.status',1)->where('product.id',$id)
    //     ->with(['languages' => function($query) use($languages_id) {
    //             $query->where('languages_id','=',$languages_id);
    //     }])
    //     ->first();
    }

    public function getoutStandingProduct(int $record = 4){
        return $this->model->orderBy('created_at','DESC')->paginate($record);
    }
 }