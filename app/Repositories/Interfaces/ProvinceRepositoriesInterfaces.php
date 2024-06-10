<?php 

namespace App\Repositories\Interfaces;

interface ProvinceRepositoriesInterfaces {
    public function all();

    public function findByid(int $modeId,array $column=['*'],array $relation = []);
}