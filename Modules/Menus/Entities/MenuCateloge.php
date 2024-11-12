<?php
namespace  Modules\Menus\Entities;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class MenuCateloge extends Model
{
    use Cachable;
    protected $table = 'menu_cateloge';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name','keyword','status'
    ];

    public function menus(){
        return $this->hasMany(Menu::class,'menu_cateloge_id','id');
    }


    public static function getAttributeName(){
        return [
            'name' => 'Tên quản lý menus danh mục',
            'keyword' => 'Tên keyword menus danh mục',
            'status' => 'Trạng thái quản lý menus danh mục',
        ];
    }
}

