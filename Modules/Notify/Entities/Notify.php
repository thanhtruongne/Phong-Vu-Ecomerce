<?php

namespace Modules\Notify\Entities;


use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class Notify extends Model
{
    use Cachable;

    protected $table = 'notify';
    protected $table_name = "Thông báo user";
    protected $fillable = [
       'user_id',
       'user_code',
       'user_name',
       'number_hits',
       'ip_address',
       'user_type',
    ];

    public function user() {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }



}
