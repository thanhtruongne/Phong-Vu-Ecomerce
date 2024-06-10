<?php
 namespace App\Repositories;

use App\Models\ProductCateloge;
use App\Repositories\Interfaces\ProductCatelogeRepositoriesInterfaces;

 class ProductCatelogeRepositories extends BaseRepositories implements ProductCatelogeRepositoriesInterfaces  {
    
    public function __construct(ProductCateloge $model)
    {
        $this->model = $model;
    }

    public function getProductCatelogeById($id , $language  = 1) {
        return $this->model->select([
                            'product_cateloge.id',
                            'product_cateloge.image',
                            'product_cateloge.status',
                            'product_cateloge.follow',
                            'product_cateloge.album',
                            'pct.name',
                            'pct.content',
                            'pct.desc',
                            'pct.meta_title',
                            'pct.meta_desc',
                            'pct.meta_keyword',
                            'pct.meta_link',
                            ])
                            ->join('product_cateloge_translate as pct','pct.product_cateloge_id','=','product_cateloge.id')
                            ->where('pct.languages_id','=',$language)
                            ->with([
                                'product_cateloge_translate'
                            ])
                            ->find($id);
    }

    public function getProductCatelogePromotion(array $condition = [],array $relation = []) {
        $query =  $this->model->newQuery();
        $query->select([
                            'product_cateloge.id',
                            'product_cateloge.image',
                            'product_cateloge.status',
                            'product_cateloge.follow',
                            'product_cateloge.album',
                            'pct.name'
        ]);
        $query->join('product_cateloge_translate as pct','pct.product_cateloge_id','=','product_cateloge.id');
        if(!isset($condition['keyword']) && empty($condition['keyword'])) {
            foreach($condition['original'] as $key => $item) { 
                $query->where($item[0],$item[1],$item[2]);
            }
        }   
        if(isset($condition['keyword']) && !empty($condition['keyword'])) {
            foreach($condition['original'] as $index => $item) { 
                foreach($condition['keyword'] as $key => $val) {
                    $query->where([[$val[0],$val[1],$val[2]] , [$item[0],$item[1],$item[2]]]);
                }
            }
        };

        if(!empty($relation)) {
            $query->with($relation);
        }
        return $query->paginate(12);

 }


}