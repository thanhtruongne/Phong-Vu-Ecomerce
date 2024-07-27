<?php
 namespace App\Repositories;

use App\Models\OrderTransport;
use App\Repositories\Interfaces\OrderTransportFeeRepositoriesInterfaces;
 class OrderTransportFeeRepositories extends BaseRepositories implements OrderTransportFeeRepositoriesInterfaces  {
    
    public function __construct(OrderTransport $model)
    {
        $this->model = $model;
    }


 }