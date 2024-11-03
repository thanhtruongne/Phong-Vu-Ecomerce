<?php
namespace  Modules\Products\Entities;

use App\Models\Categories;
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
        'name',
        'image',
        'description',
        'content',
        'product_category_id',
        'sort',
        'price',
        'quantity',
        'album',
        // 'attributes',
        'variants',
        'status',
        'is_single',
    ];

    protected $casts = [
    //    'attributes' => 'json',
       'variants' => 'json'
    ];
    

    // public function product_cataloge() {
    //     return $this->belongsTo(ProductCateloge::class,'product_cateloge_id','id');
    // }
   
    // public function promotion() {
    //     return $this->belongsToMany(Promotion::class,'promotion_product_variant','product_id','promotion_id')
    //    ->withTimestamps();
    // }
    
    // public function product_variant() {
    //     return $this->hasMany(ProductVariant::class,'product_id','id');
    // }

    public function attributes(){
        return $this->belongsToMany(Attribute::class,'product_attribute_relation','product_id','attribute_id');
    }


    // public function categories(){
    //     return $this->belongsToMany(Categories::class,'product_cateloge_product','product_id','categories_id');
    // }



    public static function getAttributeName(){
        return [
            'name' => 'Tên sản phẩm',
            'cost' => 'Giá sản phẩm',
            'desc' => 'Mô tả sản phẩm',
            'content' => 'Nội dung sản phẩm',
            'album'=> 'Album ảnh sản phẩm',
            'image'=> 'Hình ảnh sản phẩm',
            'category_id' => 'Thuộc tính sản phẩm',
            'categories_main_id' => 'Danh mục sản phẩm',
        ];
    }
}

