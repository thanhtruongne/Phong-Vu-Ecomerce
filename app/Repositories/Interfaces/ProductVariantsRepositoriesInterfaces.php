<?php
namespace App\Repositories\Interfaces;

interface ProductVariantsRepositoriesInterfaces {
    public function findProductVariant($attributeID,$product_Id,string $type = 'single');

    public function getVariantSkuProduct(string $sku = '',string $nameCode = '',int $id = 0);
  
}