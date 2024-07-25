<?php
namespace App\Repositories\Interfaces;

interface ProductRepositoriesInterfaces {

    public function getProductById($id);

    public function FindByPromotionProduct(array $condition = [] ,  array $relation = []);

    public function getProductVariantBySkuAndCode(string $sku = '',string $nameCode = '',int $id = 0,int $languages_id = 1);
}