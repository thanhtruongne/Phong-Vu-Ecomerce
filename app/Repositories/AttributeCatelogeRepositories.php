<?php
 namespace App\Repositories;

use App\Models\AttributeCateloge;
use App\Repositories\Interfaces\AttributeCatelogeRepositoriesInterfaces;

 class AttributeCatelogeRepositories extends BaseRepositories implements AttributeCatelogeRepositoriesInterfaces  {
    
    public function __construct(AttributeCateloge $model)
    {
        $this->model = $model;
    }

    public function getAttributeCatelogeById($id , $language  = 1) {
        return $this->model->select([
                            'attribute_cateloge.id',
                            'attribute_cateloge.image',
                            'attribute_cateloge.status',
                            'attribute_cateloge.follow',
                            'attribute_cateloge.album',
                            'pct.name',
                            'pct.content',
                            'pct.desc',
                            'pct.meta_title',
                            'pct.meta_desc',
                            'pct.meta_keyword',
                            'pct.meta_link',
                            ])
                            ->join('attribute_cateloge_translate as pct','pct.attribute_cateloge_id','=','attribute_cateloge.id')
                            ->where('pct.languages_id','=',$language)
                            ->with([
                                'attribute_cateloge_translate'
                            ])
                            ->find($id);
    }

    public function AllCateloge(int $language_id = 1) {
        return $this->model->withDepth()->reversed()->with(['ancestors',
        'attribute_cateloge_translate' => function($query) use($language_id)
        {
            $query->where('languages_id',$language_id);
        }        
        ])->get()->toFlatTree();
    }

 }