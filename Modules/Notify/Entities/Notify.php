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
       'order_id',
       'subject',
       'content',
       'url',
       'created_by',
       'viewed',
       'error',
       'status',
    ];

    public function user() {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }



}
