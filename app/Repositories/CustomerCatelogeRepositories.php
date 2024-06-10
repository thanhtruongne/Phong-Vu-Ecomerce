<?php
 namespace App\Repositories;

use App\Models\CustomerCateloge;
use App\Repositories\Interfaces\CustomerCatelogeRepositoriesInterfaces;
use Exception;

 class CustomerCatelogeRepositories extends BaseRepositories implements CustomerCatelogeRepositoriesInterfaces {
    
    public function __construct(CustomerCateloge $model)
    {
        $this->model = $model;
    }


 }