<?php
namespace App\Repositories\Interfaces;

interface ProductCatelogeRepositoriesInterfaces {

    public function getProductCatelogeById($id);

    public function getProductCatelogePromotion(array $condition = [],array $relation = []) ;

    public function getChildrenDescendantsOf(int $id);
}