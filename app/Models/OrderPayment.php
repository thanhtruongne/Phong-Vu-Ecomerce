<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderPayment extends Model
{
    use HasFactory;
    
    protected $table = 'order_payment_able';
    protected $fillable = [
        'order_id',
        'payment_id',
        'methodName',
        'detail_payment',
    ];

    protected $casts = [
        'detail_payment' => 'json'
    ];

}
