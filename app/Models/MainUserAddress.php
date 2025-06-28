<?php

namespace App\Models;

use Attribute;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainUserAddress extends Model
{
    protected $table = 'main_users_address';
    protected $primaryKey = 'id';
    protected $fillable = ['receiver_name', 'receiver_email', 'receiver_phone', 'user_id', 'province_code', 'ward_code', 'address', 'default'];

    protected $appends = ['address_split'];

    protected $casts = [
        'province_code' => 'integer',
        'ward_code' => 'integer'
    ];

    public function getAddressSplitAttribute()
    {
        return $this->address . ', ' . $this->ward->fullName;
    }


    public static function boot()
    {
        parent::boot();
        static::creating(function ($query) {
            $user = auth()->user();
            if ($user) {
                $query->user_id = $user->id;
                $query->receiver_email = $user->email;
                $query->receiver_phone = $user->phone;
            }
        });
    }



    public function province()
    {
        return $this->belongsTo(Province::class, 'province_code', 'code')->select(['code', 'fullName']);
    }

    public function ward()
    {
        return $this->belongsTo(Ward::class, 'ward_code', 'code')->select(['code', 'fullName']);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public static function getAttributeName()
    {
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
