<?php

namespace App\Models;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use Cachable;
    protected $table = 'slider';
    protected $primaryKey = 'id';
    protected $fillable = ['name','content','keyword','desc','item','status'];

    protected $casts = [
        'item' => 'json'
    ];


    public static function getAttributeName(){
        return [
            'name' => 'Tên slider',
            'keyword' => 'Từ khóa slider',
            'content' => 'Nội dung slider',
            'slider' => 'Hình ảnh hoặc dữ liệu'
        ];
    }
}
