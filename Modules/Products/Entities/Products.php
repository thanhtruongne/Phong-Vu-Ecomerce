<?php
namespace  Modules\Products\Entities;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Modules\Promotions\Entities\Promotions;

class Products extends Model
{
    use Cachable,Searchable;
    protected $table = 'product';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'image',
        'description',
        'content',
        'product_category_id',
        'brand_id',
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
       'attributes' => 'json',
    ];

    public function sku_variant(){
        return $this->hasMany(SkuVariants::class,'product_id','id');
    }

    public function attributes_item(){
        return $this->belongsToMany(Attribute::class,'product_attribute_relation','product_id','attribute_id');
    }

    public function brand(){
        return $this->belongsTo(Brand::class,'brand_id','id')->select(['id','name','image']);
    }

    public function product_category(){
        return $this->belongsTo(ProductCategory::class,'product_category_id','id')->select(['name as category_name','id']);
    }

    public function promotion(){
        return $this->belongsToMany(Promotions::class,'promotion_product_relation','product_id','promotion_id');
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
            'brand_id' => 'Thương hiệu sản phẩm',
            'attribute' => 'Thuộc tính sản phẩm'
        ];
    }
        
    public function toSearchableArray(){
        $with = [
            'attributes_item','sku_variant','promotion','product_category','brand'
        ];

        $this->loadMissing($with);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'product_category_id' => $this->product_category_id,
            'brand_id' => $this->brand_id,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'status' => $this->status,
            'is_single' => $this->is_single,
        ];
    } 

    public function searchableAs(){
        return 'product_index';
    }




}

