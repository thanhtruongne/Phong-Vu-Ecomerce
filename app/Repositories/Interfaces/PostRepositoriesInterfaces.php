<?php 

namespace App\Repositories\Interfaces;

interface PostRepositoriesInterfaces {
    public function all();

    public function getPostById($id , $language  = 1);
    public function findByid(int $modeId,array $column=['*'],array $relation = []);

}