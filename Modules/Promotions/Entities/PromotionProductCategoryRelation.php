<?php
namespace  Modules\Promotions\Entities;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;


class PromotionProductCategoryRelation extends Model
{
    use Cachable;
    
    protected $table = 'promotion_product_category_relation';
    protected $primaryKey = 'id';

    protected $fillable = ['product_category_id','promotion_id'];

    
}