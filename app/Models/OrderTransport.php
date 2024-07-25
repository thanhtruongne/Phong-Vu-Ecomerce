<?php

namespace App\Models;

use App\Trait\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderTransport extends Model
{
    use HasFactory,QueryScopes;
    
    protected $table = 'order_transport_fee';
    protected $fillable = ['order_id','label_id','partner_id','option'];
    
    protected $casts = [
        'option' => 'json'
    ];
}
