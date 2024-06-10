<?php
namespace App\Repositories\Interfaces;

interface ProductCatelogeRepositoriesInterfaces {

    public function getProductCatelogeById($id , $language  = 1);

    public function getProductCatelogePromotion(array $condition = [],array $relation = []) ;
}