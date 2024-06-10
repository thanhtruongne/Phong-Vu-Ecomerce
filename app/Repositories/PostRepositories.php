<?php
 namespace App\Repositories;

use App\Models\Post;
use App\Repositories\Interfaces\PostCatalogeRepositoriesInterfaces;
use App\Repositories\Interfaces\PostRepositoriesInterfaces;

 class PostRepositories extends BaseRepositories implements PostRepositoriesInterfaces  {
    
    public function __construct(Post $model)
    {
        $this->model = $model;
    }

    public function getPostById($id , $language  = 1) {
        return $this->model->select([
                            'post.id',
                            'post.image',
                            'post.status',
                            'post.follow',
                            'post.album',
                            'post.post_cateloge_id',
                            'pct.name',
                            'pct.content',
                            'pct.desc',
                            'pct.meta_title',
                            'pct.meta_desc',
                            'pct.meta_keyword',
                            'pct.meta_link',
                            ])
                            ->join('post_translates as pct','pct.post_id','=','post.id')
                            ->where('pct.language_id','=',$language)
                            ->with([
                                'post_cataloge'
                            ])
                            ->find($id);
    }
 }