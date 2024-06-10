<?php
 namespace App\Repositories;

use App\Models\PostCataloge;
use App\Models\Posts;
use App\Repositories\Interfaces\PostCatalogeRepositoriesInterfaces;

 class PostCatelogeRepositories extends BaseRepositories implements PostCatalogeRepositoriesInterfaces  {
    
    public function __construct(PostCataloge $model)
    {
        $this->model = $model;
    }

    public function getPostCatelogeById($id , $language  = 1) {
        return $this->model->select([
                            'post_cateloge.id',
                            'post_cateloge.image',
                            'post_cateloge.status',
                            'post_cateloge.follow',
                            'post_cateloge.album',
                            'post_cateloge.parent',
                            'pct.name',
                            'pct.content',
                            'pct.description',
                            'pct.meta_title',
                            'pct.meta_desc',
                            'pct.meta_keyword',
                            'pct.meta_link',
                            ])
                            ->join('post_cateloge_translate as pct','pct.post_cateloge_id','=','post_cateloge.id')
                            ->where('pct.languages_id','=',$language)
                            ->with([
                                'posts'
                            ])
                            ->find($id);
    }
 }