<?php
 namespace App\Repositories;

use App\Models\PromotionProductVariant;
use App\Repositories\Interfaces\PromotionProductVariantRepositoriesInterfaces;
 class PromotionProductVariantRepositories extends BaseRepositories implements PromotionProductVariantRepositoriesInterfaces  {
    
    public function __construct(PromotionProductVariant $model)
    {
        $this->model = $model;
    }
    

 }