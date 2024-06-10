<?php
 namespace App\Repositories;
 
use App\Models\Routers;
use App\Repositories\Interfaces\RouterRepositoriesInterfaces;

 class RouterRepositories extends BaseRepositories implements RouterRepositoriesInterfaces  {
    
    public function __construct(Routers $model)
    {
        $this->model = $model;
    }
 }