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
                            'attribute.id',
                            'attribute.image',
                            'attribute.status',
                            'attribute.follow',
                            'attribute.album',
                            'attribute.attribute_cateloge_id',
                            'pct.name',
                            'pct.content',
                            'pct.desc',
                            'pct.meta_title',
                            'pct.meta_desc',
                            'pct.meta_keyword',
                            'pct.meta_link',
                            ])
                            ->join('attribute_translate as pct','pct.attribute_id','=','attribute.id')
                            ->where('pct.languages_id','=',$language)
                            ->with([
                                'attribute_cataloge'
                            ])
                            ->find($id);
    }

    //hảm get attribute ajax bên tạo sản phẩm
    public function searchAttribute(string $keyword = '', string $option = '' , int $languageID) {
        return $this->model->whereHas('attribute_cataloge',function($query) use($option) {
            $query->where('attribute_cateloge_id',$option);
        })->whereHas('attribute_translate',function($query) use($keyword,$languageID) {
            $query->where([['name','like','%'.$keyword.'%'],['languages_id',$languageID]]);
        })->get();
    }

    public function findAttributeByIdArray(array $data = [] , int $language_id = 1) {
        return $this->model->select(['attribute.id' , 'tb3.name'])
        ->join('attribute_translate as tb3','tb3.attribute_id','=','attribute.id')
        ->where('tb3.languages_id',$language_id)
        ->whereIn('attribute.id',$data)
        ->get();
    }
 }