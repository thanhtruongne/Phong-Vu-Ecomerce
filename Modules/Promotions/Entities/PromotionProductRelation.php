<?php
namespace  Modules\Promotions\Entities;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;


class PromotionProductRelation extends Model
{
    use Cachable;
    
    protected $table = 'promotion_product_relation';
    protected $primaryKey = 'id';
    protected $fillable = ['product_id','promotion_id'];

    
    
}