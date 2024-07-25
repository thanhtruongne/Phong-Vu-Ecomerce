<?php
 namespace App\Repositories;

use App\Models\Order;
use App\Repositories\Interfaces\OrderRepositoriesInterfaces;
 class OrderRepositories extends BaseRepositories implements OrderRepositoriesInterfaces  {
    
    public function __construct(Order $model)
    {
        $this->model = $model;
    }

    public function customPagination
    (
        array $column = ['*'],
        array $condition = [] , 
        int $page = 12, 
        array $groupBy = ['id'],
        array $extend = [] ,
        array $order = ['id' => 'desc'],
        array $join = [],
        array $whereJoins = [],
        string $is_cancel = 'no'
        //sử dụng whereRaw để truy vấn trong IN filer
     ) {
        $query = $this->model->select($column)
        ->search($condition['search'] ?? null,['code','email','phone'])
        // ->wheregroup($condition['where'] ?? [])
        ->customOrder($condition['customField'] ?? [])
        ->whereAddress($condition['address'] ?? null)
        ->whereDateTime($condition['datetime']  ?? '')
        ->groupbyorder($groupBy ?? [])
        ->extend($extend  ?? null)
        ->joinQuery($join ?? [])
        ->whereJoinQuery($whereJoins ?? [])
        ->orderbyinput($order ?? []);
        if($is_cancel == 'trashed') $query->onlyTrashed();
        return $query->paginate($page);
    }
    

 }