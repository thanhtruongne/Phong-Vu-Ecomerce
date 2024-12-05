<?php
namespace  Modules\Order\Entities;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class OrderPayment extends Model
{
    use Cachable;   
    protected $table = 'order_payment';

    protected $fillable = [
        'order_id',
        'method_payment',
        'label_id',
        'unit_payment',
        'unit_transport',
        'partner_id',
        'detail_payment',
    ];

    protected $casts = [
        'detail_payment' => 'json'
    ];
}