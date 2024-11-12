<?php
namespace  Modules\Products\Entities;

use App\Models\Categories;
use App\Trait\QueryScopes;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public static function getAttributeName(){
        return [
           
        ];
    }
}

