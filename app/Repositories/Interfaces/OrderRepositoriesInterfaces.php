<?php 

namespace App\Repositories\Interfaces;

interface OrderRepositoriesInterfaces {
   public function customPagination( array $column = ['*'],array $condition = [] , int $page = 12, array $groupBy = ['id'],array $extend = [] ,array $order = ['id' => 'desc'], array $join = [], array $whereJoins = [],string $is_cancel = 'no');
}