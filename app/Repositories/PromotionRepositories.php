<?php
 namespace App\Repositories;

use App\Models\Promotion;
use App\Repositories\Interfaces\PromotionRepositoriesInterfaces;
 class PromotionRepositories extends BaseRepositories implements PromotionRepositoriesInterfaces  {
    
    public function __construct(Promotion $model)
    {
        $this->model = $model;
    }
    

    public function findByProductPromotion($product_id) {
     
     return   $this->model->select(
            'promotion.id',
            'promotion.discountValue',
            'promotion.discountType',
            'promotion.maxDiscountValue',
            'product.price as product_price',
            'product.id as product_id'
       )
        ->selectRaw(
            "
                MAX(
                    IF(promotion.maxDiscountValue != 0,
                        LEAST(
                            CASE  
                                WHEN discountType = 'VND' THEN discountValue
                                WHEN discountType = '%' THEN (product.price * discountValue) / 100
                                ELSE 0
                            END,
                                promotion.maxDiscountValue
                            ),
                        CASE  
                            WHEN discountType = 'VND' THEN  discountValue
                            WHEN discountType = '%' THEN (product.price * discountValue) / 100
                            ELSE 0
                        END 
                    ) 
                )  as discount
            "
         )
        ->join('promotion_product_variant as ppv','ppv.promotion_id','=','promotion.id')
        ->join('product','product.id','=','ppv.product_id')
        ->where([['product.status','=',1],['promotion.status','=',1]])
        ->whereIn('product.id',$product_id)
        ->whereDate('promotion.endDate','>',now())
        ->groupBy('product_id')
        ->get()->toArray();
        
    }

    public function getProductVariantPromotion(array $variant_id = []) {
     
        return $this->model->select(
               'promotion.id',
               'promotion.discountValue',
               'promotion.discountType',
               'promotion.maxDiscountValue',
               'product_variant.price as product_variant_price',
               'product_variant.id as product_variant_id'
          )
          ->selectRaw(
            "
                MAX(
                    IF(promotion.maxDiscountValue != 0,
                        LEAST(
                            CASE  
                                WHEN discountType = 'VND' THEN discountValue
                                WHEN discountType = '%' THEN (product_variant.price * discountValue) / 100
                                ELSE 0
                            END,
                                promotion.maxDiscountValue
                            ),
                        CASE  
                            WHEN discountType = 'VND' THEN  discountValue
                            WHEN discountType = '%' THEN (product_variant.price * discountValue) / 100
                            ELSE 0
                        END 
                    ) 
                )  as discount
            "
         )
           ->join('promotion_product_variant as ppv','ppv.promotion_id','=','promotion.id')
           ->join('product_variant','product_variant.id','=','ppv.product_variant_id')
        //    ->where([['product.status','=',1],['promotion.status','=',1],['product_variant.status','=',1]])
           ->whereIn('product_variant.id',$variant_id)
           ->whereDate('promotion.endDate','>',now())
           ->groupBy('product_variant_id')
           ->get()->toArray();
           
       }

 }