<?php
 namespace App\Repositories;

use App\Models\GenerateModule;
use App\Repositories\Interfaces\GenerateModuleRepositoriesInterfaces;

 class GenerateModuleRepositories extends BaseRepositories implements GenerateModuleRepositoriesInterfaces  {

    public function __construct(GenerateModule $model)
    {
        $this->model = $model;
    }


 }