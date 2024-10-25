<?php
namespace  Modules\Products\Entities;

use App\Trait\QueryScopes;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Products extends Model
{
    use Cachable;
    protected $table = 'product';
    protected $primaryKey = 'id';
    protected $fillable = [
        'image',
        'galley',
        'status',    
        'product_cateloge_id',
        // 'attribu/ste////
        'variant',
        'code_product',
        'price',
        'name',
        'content',
        'desc',
        'qualnity',
        'attributeFilter',
        'sku',
    ];

    // protected $casts = [
    //    'attribute' => 'json',
    // ];
    

    public function product_cataloge() {
        return $this->belongsTo(ProductCateloge::class,'product_cateloge_id','id');
    }
   
    // public function promotion() {
    //     return $this->belongsToMany(Promotion::class,'promotion_product_variant','product_id','promotion_id')
    //    ->withTimestamps();
    // }
    
    public function product_variant() {
        return $this->hasMany(ProductVariant::class,'product_id','id');
    }

    public function attributes(){
        return $this->belongsToMany(Attribute::class,'product_attribute_relation','product_id','attribute_id');
    }


    public static function getAttributeName(){
        return [
            'name' => 'Tên sản phẩm',
            'cost' => 'Giá sản phẩm',
            'desc' => 'Mô tả sản phẩm',
            'content' => 'Nội dung sản phẩm',
            'album'=> 'Ảnh sản phẩm',
            'category_id' => 'Danh mục sản phẩm'
        ];
    }
}

