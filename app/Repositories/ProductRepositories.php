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

    public function getProductById($id , $language_id  = 1) {
        return $this->model->select([
                            'product.id',
                            'product.image',
                            'product.status',
                            'product.follow',
                            'product.album',
                            'product.product_cateloge_id',
                            'product.variant',
                            'product.attribute',
                            'product.attributeCateloge',
                            'product.code_product',
                            'product.form',
                            'product.price',
                            'pct.name',
                            'pct.content',
                            'pct.desc',
                            'pct.meta_title',
                            'pct.meta_desc',
                            'pct.meta_keyword',
                            'pct.meta_link',
                            ])
                            ->join('product_translate as pct','pct.product_id','=','product.id')
                            ->where('pct.languages_id','=',$language_id)
                            ->with([
                                'product_cataloge',
                                'product_variant' => function($query) use($language_id) {
                                    $query->with(['attributes' => function($query) use($language_id) {
                                        $query->with(['attribute_translate' => function($query) use($language_id) {
                                            return $query->where('languages_id',$language_id);
                                        }]);
                                    }]);
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
            DB::raw('CONCAT(prtrans.name,"-",COALESCE(pvtrans.name,"mặc định")) as variant_name_translate')
        ]);
        $query->join('product_translate as prtrans','prtrans.product_id', '=' ,'product.id');
        $query->leftJoin('product_variant as pv2','pv2.product_id', '=' ,'product.id');
        $query->leftJoin('product_variant_translate as pvtrans','pvtrans.product_variant_id', '=' ,'pv2.id');

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
 }