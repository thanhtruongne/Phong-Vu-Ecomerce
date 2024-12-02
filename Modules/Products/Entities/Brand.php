<?php
namespace  Modules\Products\Entities;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use Cachable;
    
    protected $table = 'brand';
    protected $primaryKey = 'id';
    protected $fillable = ['image','order','status','content','name'];

    public function products(){
        return $this->hasMany(Products::class,'brand_id','id');
    }
    public static function getAttributeName(){
        return [
            'name' => 'Tên thương hiệu',
            'status' => 'Trạng thái thương hiệu'
        ];
    }

}