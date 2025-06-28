<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Models\MainUserAddress;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasRoles, HasApiTokens;

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
        'phone',
        'avatar',
        'status',
        'desc',
        'google_id'
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
    protected $appends = ['full_name', 'address_default_split'];

    public function getAddressDefaultSplitAttribute()
    {
        return $this->usersAddress->where('default', 1)->first()?->address_split;
    }


    public function getFullNameAttribute()
    {
        return $this->firstname . ' ' . $this->lastname;
    }


    public function usersAddress()
    {
        return $this->hasMany(MainUserAddress::class, 'user_id', 'id')->orderBy('default', 'desc');
    }

    public function isAdmin()
    {
        if (in_array(auth()->user()->username, ['admin', 'superadmin']))
            return true;

        return false;
    }

    public static function getAttributeName()
    {
        return [
            'username' => "Tài khoản",
            "password" => "Mật khẩu",
            "email" => "Email"
        ];
    }
}
