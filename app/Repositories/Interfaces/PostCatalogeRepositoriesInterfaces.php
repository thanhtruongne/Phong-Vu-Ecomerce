<?php 

namespace App\Repositories\Interfaces;

interface PostCatalogeRepositoriesInterfaces {
    public function all();

    public function getPostCatelogeById($id , $language  = 1);
    public function findByid(int $modeId,array $column=['*'],array $relation = []);

}