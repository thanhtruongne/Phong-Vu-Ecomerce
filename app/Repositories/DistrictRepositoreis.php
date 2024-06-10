<?php
 namespace App\Repositories;

use App\Models\District;
use App\Repositories\Interfaces\DistrictRepositoriesInterfaces;

 class DistrictRepositoreis extends BaseRepositories implements DistrictRepositoriesInterfaces  {

    public function __construct(District $model)
    {
        $this->model = $model;
    }

 }