<?php
namespace  Modules\Order\Entities;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use Cachable;   
    protected $table = 'order_item';
    protected $primaryKey = 'id';

    protected $fillable = [
        'order_id',
        'product_id',
        'product_image',
        'product_brand',
        'product_price',
        'quantity',
        'sku_id',
        'product_category_id',
        'promotion_name',
        'promotion_amount',
        'sku_code',
        'product_attribute',
    ];
}