<?php
 namespace App\Repositories;

use App\Models\Customer;
use App\Repositories\Interfaces\CustomerRepositoriesInterfaces;
use Exception;


 class CustomerRepositories extends BaseRepositories implements CustomerRepositoriesInterfaces {
    public function __construct(Customer $model){
        $this->model = $model;
    } 


 }