<?php
namespace App\Repositories\Interfaces;

interface ProductRepositoriesInterfaces {

    public function getProductById($id);

    public function FindByPromotionProduct(array $condition = [] ,  array $relation = []);

}