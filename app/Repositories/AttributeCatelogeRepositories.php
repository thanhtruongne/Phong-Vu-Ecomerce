<?php
 namespace App\Repositories;

use App\Models\AttributeCateloge;
use App\Repositories\Interfaces\AttributeCatelogeRepositoriesInterfaces;

 class AttributeCatelogeRepositories extends BaseRepositories implements AttributeCatelogeRepositoriesInterfaces  {
    
    public function __construct(AttributeCateloge $model)
    {
        $this->model = $model;
    }

    public function getAttributeCatelogeById($id) {
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

    public function AllCateloge(array $select = ['*']) {
        return $this->model->select($select)->withDepth()->reversed()->with(['ancestors'])->get()->toFlatTree();
    }



    

 }