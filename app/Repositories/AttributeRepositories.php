<?php
namespace App\Repositories;

use App\Models\Attribute;
use App\Repositories\Interfaces\AttributeRepositoriesInterfaces;

 class AttributeRepositories extends BaseRepositories implements AttributeRepositoriesInterfaces  {
    
    public function __construct(Attribute $model)
    {
        $this->model = $model;
    }

    public function getAttributeById($id , $language  = 1) {
        return $this->model->select([
                            'id',
                            'image',
                            'status',
                            'album',
                            'attribute_cateloge_id',
                            'name',
                            'content',
                            'desc',
                            'meta_title',
                            'meta_desc',
                            'meta_keyword',
                            'canonical',
                            ])
                            ->with([
                                'attribute_cataloge'
                            ])
                            ->find($id);
    }

    //hảm get attribute ajax bên tạo sản phẩm
    public function searchAttribute(string $keyword = '', string $option = '') {
        return $this->model
        ->where('name','like','%'.$keyword.'%')
        ->whereHas('attribute_cataloge',function($query) use($option) {
            $query->where('attribute_cateloge_id',$option);
        })->get();
    }

    public function findAttributeByIdArray(array $data = [] ) {
        return $this->model->select(['id' , 'name'])
        ->whereIn('id',$data)
        ->get();
    }

    public function getAttributeByWhereIn(array $id = []) {
        return $this->model->select(
            'attribute_cateloge_id',
            'name',
            'id',
        )
        ->where( 'status',1)
        ->whereIn('id',$id)
        ->get();
    }

    public function findAttributeProductVariantID(array $data = [] , $productCatelogeID) {
        return $this->model->select([
          'attribute.id'
        ])
        ->leftJoin('product_variant_attribute as pva','pva.attribute_id','=','attribute.id')
        ->leftJoin('product_variant as pv','pv.id','=','pva.product_variant_id')
        ->leftJoin('product_cateloge_product as pcp','pcp.product_id','=','pv.product_id')
        ->where('pcp.product_cateloge_id','=',$productCatelogeID)
        ->whereIn('attribute.id',$data)
        ->distinct()
        ->pluck('attribute.id');
  
    }
 }