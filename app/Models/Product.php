<?php
namespace App\Models;

use App\Trait\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory,QueryScopes;
    protected $table = 'product';
    protected $primaryKey = 'id';
    protected $fillable = [
        'image',
        'album',
        'status',    
        'product_cateloge_id',
        'attribute',
        'attributeCateloge',
        'variant',
        'code_product',
        'price','form',
        'name','content','desc','meta_title','meta_desc','meta_keyword','canonical',
        'demand_product_id  '
    ];

    

    public function product_cataloge() {
        return $this->belongsTo(ProductCateloge::class,'product_cateloge_id','id');
    }
   
    public function promotion() {
        return $this->belongsToMany(Promotion::class,'promotion_product_variant','product_id','promotion_id')
       ->withTimestamps();
    }

    public function product_cateloge_product() {
        return $this->belongsToMany(ProductCateloge::class,'product_cateloge_product','product_id','product_cateloge_id');
    }
    
    public function product_variant() {
        return $this->hasMany(ProductVariant::class,'product_id','id')->with('attributes');
    }
}

