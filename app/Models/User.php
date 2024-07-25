<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Trait\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable,HasApiTokens,QueryScopes;
    protected $guard = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',    
        'password',
        'province_code',
        'district_code',
        'ward_code',
        'address',
        'phone',
        'thumb',
        'status',
        'desc',
        'user_cataloges_id'
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





    public function user_cataloge() {
        return $this->belongsTo(UserCataloge::class,'user_cataloges_id','id');
    }

    public function hasPermission($permissionName) {
        return $this->user_cataloge->permissions->contains('canonical',$permissionName);
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
