<?php
 namespace App\Repositories;

use App\Models\Ward;
use App\Repositories\Interfaces\WardRepositoriesInterfaces;

 class WardRepositoreis  extends BaseRepositories implements WardRepositoriesInterfaces {
    

    public function __construct(Ward $model)
    {
        $this->model = $model;
    }

    public function getWardByCode(string $code) {
        return $this->model->where('district_code','=',$code)->get();
    }
 }