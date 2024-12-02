<?php
namespace  Modules\Products\Entities;

use App\Models\Categories;
use App\Trait\QueryScopes;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Promotions\Entities\Promotions;
use Modules\Products\Entities\Products;
class SkuVariants extends Model
{
    use Cachable;
    protected $table = 'sku_variants';
    protected $primaryKey = 'id';
    protected $fillable = [
        'sku_idx',
        'product_id',
        'name',
        'sku_code',
        'slug',
        'price',
        'sort',
        'stock',
        'default',
        'album',
        'attributes'
    ];

    protected $casts = [
        'sku_idx' => 'json',
        'album' => 'json',
        'attributes' => 'json'
    ];

    public function promotion(){
        return $this->belongsToMany(Promotions::class,'promotion_variants_relation','sku_id','promotion_id');
    }

    public function product(){
        return $this->belongsTo(Products::class,'product_id','id');
    }

    public static function getAttributeName(){
        return [
           
        ];
    }
}

