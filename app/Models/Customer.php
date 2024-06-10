<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Trait\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Authenticatable
{
    use HasApiTokens, HasFactory,Notifiable,SoftDeletes,QueryScopes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = 'customer';
    protected $fillable = [
        'name',
        'email',
        'fullname',
        'birthday',
        'password',
        'province_code',
        'district_code',
        'ward_code',
        'address',
        'phone',
        'thumb',
        'status',
        'ip',
        'user_agent',
        'desc',
        'customer_cateloge_id'
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
    protected $attributes = [
       'status' => 1
    ];
 

    public function customer_cateloge() {
        return $this->belongsTo(CustomerCateloge::class,'customer_cateloge_id','id');
    }

}
