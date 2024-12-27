<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainUserAddress extends Model
{
    use Cachable;

    protected $table = 'main_users_address';
    protected $primaryKey = 'id';
    protected $fillable = ['receiver_name','receiver_email','receiver_phone','user_id','province_code','district_code','ward_code','address'];


    public function province() {
        return $this->belongsTo(Province::class,'province_code','code')->select(['code','full_name']);
      }

    public function district() {
        return $this->belongsTo(District::class,'district_code','code')->select(['code','full_name']);
    }

    public function ward() {
        return $this->belongsTo(Ward::class,'ward_code','code')->select(['code','full_name']);
    }

    public function user() {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public static function getAttributeName(){
        return [
            'user_id' => 'Người dùng',
            'receiver_name' => 'Tên người nhận',
            'receiver_email' => 'Email',
            'receiver_phone' => 'Số điện thoại',
            'province_code' => 'Tỉnh/Thành',
            'district_code' => 'Quận/Huyện',
            'ward_code' => 'Phường/Xã',
            'address' => 'Địa chỉ',
        ];
    }
}
