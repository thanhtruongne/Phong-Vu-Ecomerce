<?php
 namespace App\Repositories;

use App\Models\Province;
use App\Repositories\Interfaces\ProvinceRepositoriesInterfaces;

 class ProvinceRepositoreis extends BaseRepositories implements ProvinceRepositoriesInterfaces  {
    
    public function __construct(Province $model)
    {
        $this->model = $model;
    }
 }