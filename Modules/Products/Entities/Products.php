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
        'album',
        'status',    
        'product_cateloge_id',
        'attribute',
        'variant',
        'code_product',
        'price',
        'name',
        'content',
        'desc',
    ];

    

    public function product_cataloge() {
        return $this->belongsTo(ProductCateloge::class,'product_cateloge_id','id');
    }
   
    // public function promotion() {
    //     return $this->belongsToMany(Promotion::class,'promotion_product_variant','product_id','promotion_id')
    //    ->withTimestamps();
    // }
    
    public function product_variant() {
        return $this->hasMany(ProductVariant::class,'product_id','id')->with('attributes');
    }
}

