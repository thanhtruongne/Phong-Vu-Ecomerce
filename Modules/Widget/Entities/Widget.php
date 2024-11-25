<?php
namespace  Modules\Widget\Entities;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class Widget extends Model
{
    use Cachable;
    
    protected $table = 'widget';
    protected $primaryKey = 'id';

    protected $fillable = ['name','keyword','content','model_id','short_code','image','status'];

    protected $casts = [
        'model_id' => 'json'
    ];
    public static function getAttributeName() {
        return [
            'name' => 'Tên widget',
            'model_id' => 'Dữ liệu widget',
            'image' => 'Hình ảnh widget',
            'keyword' => 'Từ khóa widget',
            'short_code' => 'Mã widget',
        ];
    }
}