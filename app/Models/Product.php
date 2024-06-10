<?php
namespace App\Models;

use App\Trait\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes,QueryScopes;
    protected $table = 'product';
    protected $primaryKey = 'id';
    protected $fillable = [
        'image',
        'icon',
        'album',
        'status',    
        'order',
        'user_id',
        'follow',
        'product_cateloge_id',
        'attribute',
        'attributeCateloge',
        'variant',
        'code_product',
        'price','form'
    ];
    

    public function product_cataloge() {
        return $this->belongsTo(ProductCateloge::class,'product_cateloge_id','id');
    }

    public function product_translate() {
        return $this->hasMany(ProductTranslate::class,'product_id','id');
    }

    public function languages() {
        return $this->belongsToMany(Languages::class,'product_translate','product_id','languages_id')
        ->withPivot(['name','content','desc','meta_title','meta_keyword','meta_desc','meta_link'])->withTimestamps();
    }
   
    public function promotion() {
        return $this->belongsToMany(Promotion::class,'promotion_product_variant','product_id','promotion_id')
       ->withTimestamps();
    }

    public function product_cateloge_product() {
        return $this->belongsToMany(ProductCateloge::class,'product_cateloge_product','product_id','product_cateloge_id');
    }
    
    public function product_variant() {
        return $this->hasMany(ProductVariant::class,'product_id','id');
    }
}

