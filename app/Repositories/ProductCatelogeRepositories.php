<?php
 namespace App\Repositories;

use App\Models\ProductCateloge;
use App\Repositories\Interfaces\ProductCatelogeRepositoriesInterfaces;

 class ProductCatelogeRepositories extends BaseRepositories implements ProductCatelogeRepositoriesInterfaces  {
    
    public function __construct(ProductCateloge $model)
    {
        $this->model = $model;
    }

    public function getProductCatelogeById($id) {
        return $this->model->select([
                            'id',
                            'image',
                            'status',
                            'album',
                            'name',
                            'content',
                            'desc',
                            'meta_title',
                            'meta_desc',
                            'meta_keyword',
                            'canonical',
                            'attributes'
                            ])
                            ->with([
                                'products'
                            ])
                            ->find($id);
    }

    public function getProductCatelogePromotion(array $condition = [],array $relation = []) {
        $query =  $this->model->newQuery();
        $query->select(['id','image','status','follow','album', 'name']);
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

    // pul

    public function getParentAncestorsOf($id){
        return $this->model->select(['name','canonical','id','parent','attributes','id','image','album'])->ancestorsOf($id);
    }
     
    public function getChildDencestorsOf($id){
        return $this->model->descendantsAndSelf($id);
    }
    public function getChildrenDescendantsOf(int $id){
        return $this->model->select([
            'id','image','name','canonical','album','parent','attributes'
        ])
        // ->withDepth()->having('depth', '=', 2)->get();
        ->descendantsOf($id)->toTree($id);
    }


}