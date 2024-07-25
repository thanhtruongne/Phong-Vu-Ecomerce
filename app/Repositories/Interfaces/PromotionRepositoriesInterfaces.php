<?php 

namespace App\Repositories\Interfaces;

interface PromotionRepositoriesInterfaces {
    public function findByProductPromotion($product_id);

    public function getProductVariantPromotion(array $variant_id = []);

}