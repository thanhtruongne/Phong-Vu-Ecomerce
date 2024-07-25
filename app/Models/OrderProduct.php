<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderProduct extends Model
{
    use HasFactory;
    
    protected $table = 'order_product';
    protected $fillable = [
        'product_id',
        'order_id',
        'uuid',
        'name',
        'qty',
        'price',
        'priceSale',
        'option',
        'promotion',
    ];

    protected $casts  = [
        'option' => 'json'
    ];

}
