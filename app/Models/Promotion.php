<?php
namespace App\Models;

use App\Trait\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promotion extends Model
{
    use HasFactory,SoftDeletes,QueryScopes;
    protected $table = 'promotion';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'code',
        'startDate',
        'endDate',    
        'neverEndDate',
        'status',
        'follow',
        'promotionMethod',
        'desc',
        'info',
        'maxDiscountValue',
        'discountValue',
        'discountType',
    ];

    protected $casts = [
        'info' => 'json',
    ];
    
    public function products() {
        return $this->belongsToMany(Product::class,'promotion_product_variant','promotion_id','product_id')
        ->withPivot(['product_variant_id','model'])
        ->withTimestamps();
    }
    
    public function product_cateloge() {
        return $this->belongsToMany(ProductCateloge::class,'promotion_product_cateloge','promotion_id','product_cateloge_id')
        ->withPivot('model')
        ->withTimestamps();
    }
}

