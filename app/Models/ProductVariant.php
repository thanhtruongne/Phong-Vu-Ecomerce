<?php
namespace App\Models;

use App\Trait\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariant extends Model
{
    use HasFactory ,SoftDeletes,QueryScopes;
    protected $table = 'product_variant';
    protected $primaryKey = 'id';
    protected $fillable = ['code','sku','album','status','barcode','price','qualnity','user_id','file_name','file_url','product_id'];
    

    public function languages() {
        return $this->belongsToMany(Languages::class,'product_variant_translate','product_variant_id','languages_id')
        ->withPivot(['name'])->withTimestamps();
    }

    public function product_variant_transltate() {
        return $this->hasMany(ProductVariantTranslate::class,'product_variant_id','id');
    }
    
    public function product() {
        return $this->belongsTo(Product::class,'product_id','id');
    }



    public function attributes() {
        return $this->belongsToMany(Attribute::class,'product_variant_attribute','product_variant_id','attribute_id');
    }
}

