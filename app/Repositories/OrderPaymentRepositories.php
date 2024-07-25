<?php
 namespace App\Repositories;

use App\Models\OrderPayment;
use App\Repositories\Interfaces\OrderPaymentRepositoriesInterfaces;
 class OrderPaymentRepositories extends BaseRepositories implements OrderPaymentRepositoriesInterfaces  {
    
    public function __construct(OrderPayment $model)
    {
        $this->model = $model;
    }

 }