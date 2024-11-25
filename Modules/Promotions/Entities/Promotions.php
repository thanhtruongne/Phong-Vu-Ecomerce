<?php
namespace  Modules\Promotions\Entities;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;
use Modules\Products\Entities\ProductCategory;
use Modules\Products\Entities\Products;
use Modules\Products\Entities\SkuVariants;

class Promotions extends Model
{
    use Cachable;
    
    protected $table = 'promotions';
    protected $primaryKey = 'id';

    protected $fillable = ['name','description','thumbnail','code','count','amount','startDate','endDate','neverEndDate','status','type'];

    
    public function products(){
        return $this->belongsToMany(Products::class,'promotion_product_relation','promotion_id','product_id')
        ->select('name','product_id','price','quantity','views','sku_code','type','image');
    }
    public function sku_variants(){
        return $this->belongsToMany(SkuVariants::class,'promotion_variants_relation','promotion_id','sku_id');
    }

    public function product_category(){
        return $this->belongsToMany(ProductCategory::class,'promotion_product_category_relation','promotion_id','product_category_id');
    }

    public static function getAttributeName(){
        return [
            'name' => 'Tên khuyến mãi',
            'code' => 'Mã khuyến mãi',
            'amount' => 'Giá khuyến mãi',
            'description' => 'Mô tả khuyến mãi',
            'startDate' => 'Thời gian bắt đầu',
            'endDate' => 'Thời gian kết thúc'
        ];
    }
}