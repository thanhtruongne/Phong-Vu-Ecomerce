<?php
namespace App\Models;

use App\Trait\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariant extends Model
{
    use HasFactory,QueryScopes;
    protected $table = 'product_variant';
    protected $primaryKey = 'id';
    protected $fillable = ['code','sku','album','status','barcode','price','qualnity','user_id','file_name','file_url','product_id','name'];
    
    
    public function product() {
        return $this->belongsTo(Product::class,'product_id','id');
    }
    public function attributes() {
        return $this->belongsToMany(Attribute::class,'product_variant_attribute','product_variant_id','attribute_id');
    }
}

