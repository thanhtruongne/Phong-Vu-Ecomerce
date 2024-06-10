<?php
namespace App\Repositories\Interfaces;

interface ProductRepositoriesInterfaces {

    public function getProductById($id , $language  = 1);

    public function FindByPromotionProduct(array $condition = [] ,  array $relation = []);
}