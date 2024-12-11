<?php
namespace  Modules\Order\Entities;

use App\Models\District;
use App\Models\Province;
use App\Models\Ward;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use Cachable;   
    protected $table = 'orders';
    protected $primaryKey = 'id';

    protected $fillable = [
        'code',
        'user_id',
        'create_time',
        'user_name',
        'total_amount',
        'freight_amount',
        'promotion_amount',
        'pay_type',
        'status',
        'delivery_company',
        'delivery_code',
        'receiver_name',
        'receiver_phone',
        'receiver_province',
        'receiver_district',
        'receiver_ward',
        'receiver_address',
        'confirm_status',
        'delete_status',
        'note',
        'receiver_email',
        'payment_time',
        'delivery_time',
    ];

    public function order_items(){
        return $this->hasMany(OrderItem::class,'order_id','id');
    }
    public function order_payment(){
        return $this->belongsTo(OrderPayment::class,'order_id','id');
    }

    public function province(){
        return $this->belongsTo(Province::class,'receiver_province','code')->select('full_name');
    }
    public function district(){
        return $this->belongsTo(District::class,'receiver_province','code')->select('full_name');
    }
    public function ward(){
        return $this->belongsTo(Ward::class,'receiver_province','code')->select('full_name');
    }

    public static function getAttributeName(){
        return [
            'total_amount' => 'Tổng số tiền',
            'freight_amount' => "Số tiền vận chuyển",
            'receiver_name' => 'Tên người nhận',
            'receiver_province' => 'Thành phồ / Tỉnh',
            'receiver_district' => 'Quận / Huyện',
            'receiver_ward' => 'Phường / Xã',
            'receiver_phone' => 'Sớ điện thoại',
            'receiver_address' => 'Địa chỉ người nhận',
            'receiver_email' => 'Email người nhận',
            'method_payment' => 'Phương thức thanh toán',
        ];
    }
}