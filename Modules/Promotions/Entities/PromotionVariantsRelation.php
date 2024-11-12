<?php
namespace  Modules\Promotions\Entities;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;


class PromotionVariantsRelation extends Model
{
    use Cachable;
    
    protected $table = 'promotion_variants_relation';
    protected $primaryKey = 'id';

    protected $fillable = ['sku_id','promotion_id'];

    
}