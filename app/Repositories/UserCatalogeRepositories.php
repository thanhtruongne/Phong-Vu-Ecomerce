<?php
 namespace App\Repositories;
use App\Models\UserCataloge;
use App\Repositories\Interfaces\UserCatalogeRepositoriesInterface;
use Exception;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

 class UserCatalogeRepositories extends BaseRepositories implements UserCatalogeRepositoriesInterface {
    
    public function __construct(UserCataloge $model)
    {
        $this->model = $model;
    }


 }