<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable,HasRoles,Cachable;

    protected $table = 'user';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',    
        'firstname',
        'username',
        'lastname',
        're_login',
        'type_user',
        'role',
        'dob',
        'gender',
        'signing_create_account',
        'content',
        'province_code',
        'district_code',
        'ward_code',
        'address',
        'phone',
        'avatar',
        'status',
        'desc',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function province() {
        return $this->belongsTo(Province::class,'province_id','id');
      }
  
      public function district() {
        return $this->belongsTo(District::class,'district_id','id');
      }
  
      public function ward() {
        return $this->belongsTo(Ward::class,'ward_id','id');
      }

      public function isAdmin(){
        if (in_array(auth()->user()->username, ['admin', 'superadmin'])) 
          return true;
        
        return false;

      }

      public static function getAttributeName() {
          return [
            'username' => "Tài khoản",
            "password" => "Mật khẩu",
            "email" => "Email"
          ];
      }

}
