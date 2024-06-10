<?php
 namespace App\Repositories;

use App\Models\Permissions;
use App\Repositories\Interfaces\PermissionsRepositoriesInterfaces;

 class PermissionsRepositories extends BaseRepositories implements PermissionsRepositoriesInterfaces  {
    
    public function __construct(Permissions $model)
    {
        $this->model = $model;
    }

 }