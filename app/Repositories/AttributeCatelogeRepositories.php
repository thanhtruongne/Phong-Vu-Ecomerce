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
                            ])
                            ->find($id);
    }

    public function AllCateloge(int $language_id = 1) {
        return $this->model->withDepth()->reversed()->with(['ancestors'])->get()->toFlatTree();
    }



    

 }