<?php 

namespace App\Repositories\Interfaces;

interface DistrictRepositoriesInterfaces {
    public function all();

    public function findByid(int $modeId,array $column=['*'],array $relation = []);
    
}