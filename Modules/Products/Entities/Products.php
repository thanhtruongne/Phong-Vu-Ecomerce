<?php
namespace  Modules\Products\Entities;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use Cachable;
    protected $table = 'product';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'image',
        'description',
        'content',
        'product_category_id',
        'sort',
        'price',
        'quantity',
        'album',
        'attributes',
        'variants',
        'status',
        'is_single',
    ];

    protected $casts = [
       'variants' => 'json',
       'attributes' => 'json'
    ];

    public function sku_variants(){
        return $this->hasMany(SkuVariants::class,'product_id','id');
    }

    public function attributes_item(){
        return $this->belongsToMany(Attribute::class,'product_attribute_relation','product_id','attribute_id');
    }


    public static function getAttributeName(){
        return [
            'name' => 'Tên sản phẩm',
            'cost' => 'Giá sản phẩm',
            'desc' => 'Mô tả sản phẩm',
            'content' => 'Nội dung sản phẩm',
            'album'=> 'Album ảnh sản phẩm',
            'image'=> 'Hình ảnh sản phẩm',
            'category_id' => 'Danh mục sản phẩm',
            'attribute' => 'Thuộc tính sản phẩm'
        ];
    }
}

