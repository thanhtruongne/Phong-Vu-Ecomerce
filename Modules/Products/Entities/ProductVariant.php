<?php
namespace  Modules\Products\Entities;

use App\Models\Categories;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use Cachable;
    protected $table = 'product_variant';
    protected $primaryKey = 'id';
    protected $fillable = [
        'product_id',
        'user_id',
        'code',
        'sku',
        'image',
        'album',
        'status',    
        'attribute',
        'price',
        'name',
        'content',
        'desc',
    ];


    public function products(){
        return $this->belongsTo(Products::class,'product_id','id');
    }

    
    public function categories(){
        return $this->belongsToMany(Categories::class,'product_cateloge_variant','product_variant_id','categories_id');
    }

}




