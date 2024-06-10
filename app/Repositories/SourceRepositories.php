<?php
 namespace App\Repositories;
use App\Models\Source;
use App\Repositories\Interfaces\SourceRepositoriesInterfaces;

 class SourceRepositories extends BaseRepositories implements SourceRepositoriesInterfaces {
    
    public function __construct(Source $model)
    {
        $this->model = $model;
    }


 }