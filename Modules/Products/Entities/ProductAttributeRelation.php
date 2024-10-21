<?php
namespace  Modules\Products\Entities;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;


class ProductAttributeRelation extends Model
{
    use Cachable;
    protected $table = 'product_attribute_relation';
    protected $fillable = ['product_id','user_id','attribute_id'];
}