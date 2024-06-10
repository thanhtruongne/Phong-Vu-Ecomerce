<?php
namespace App\Repositories;

use App\Models\System;
use App\Repositories\Interfaces\SystemRepositoriesInterfaces;

 class SystemRepositories extends BaseRepositories implements SystemRepositoriesInterfaces  {
    
    public function __construct(System $model)
    {
        $this->model = $model;
    }

 }