<?php

namespace App\Models;

use App\Trait\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory,SoftDeletes,QueryScopes;
    
    protected $table = 'order';
    protected $fillable = [
        'name',
        'email',
        'address',
        'phone',
        'cart',
        'created',
        'province_code',
        'ward_code',
        'district_code',
        'desc',
        'promotions',
        'customer_id',
        'guest_cookie',
        'method',
        'code',
        'confirm',
        'shipping',
        'payment',
        'shipping_rule',
        'shipping_options',
        'is_transport',
        'is_cancel',
        'is_send_mail'
    ];

    protected $casts = [
      'cart' => 'json',
      'shipping_options' => 'json'
    ];


    public function Order_products() {
       return $this->belongsToMany(Product::class,'order_product','order_id','product_id')->withPivot([
         'uuid','name','qty','price','priceSale','option','promotion'
       ])->withTimestamps();
    }

    public function order_transport_fee() {
      return $this->hasOne(OrderTransport::class,'order_id','id');
    }

    public function order_payment() {
      return $this->hasOne(OrderPayment::class,'order_id','id');
    }

    public function province() {
      return $this->belongsTo(Province::class,'province_code','code');
    }

    public function district() {
      return $this->belongsTo(District::class,'district_code','code');
    }


    public function ward() {
      return $this->belongsTo(Ward::class,'ward_code','code');
    }


}
