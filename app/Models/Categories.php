<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kalnoy\Nestedset\NodeTrait;
use Modules\Products\Entities\Products;
use Modules\Products\Entities\ProductVariant;

class Categories extends Model
{
    use NodeTrait;

    protected $table = 'categories';
    protected $table_name = "Danh mục sản phẩm";
    protected $primaryKey = 'id';
    protected $fillable = [
        'parent_id',
        '_lft',
        '_rgt',
        'icon',
        'image',
        'url',
        'name',
        'status',
        'ikey'
    ];
    public function getLftName()
    {
        return '_lft';
    }
    
    public function getRgtName()
    {
        return '_rgt';
    }
    
    public function getParentIdName()
    {
        return 'parent_id';
    }
    
    // Specify parent id attribute mutator
    public function setParentAttribute($value)
    {
        $this->setParentIdAttribute($value);
    }

    public function product_cateloge_product(){
        return $this->belongsToMany(Products::class,'product_cateloge_product','categories_id','product_id');
    }

    public function product_cateloge_variant(){
        return $this->belongsToMany(ProductVariant::class,'product_cateloge_variant','categories_id','product_variant_id');
    }
    public static function getAttributeName(){
        return [
            'name' => 'Tên danh mục',
            'url' => 'Đường dẫn danh mục',
            // 'name' => 'Tên danh mục',
        ];
    }


}
