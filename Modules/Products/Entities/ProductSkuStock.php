<?php
namespace  Modules\Products\Entities;

use App\Models\Categories;
use App\Trait\QueryScopes;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSkuStock extends Model
{
    use Cachable;
    protected $table = 'products_sku_stocks';
    protected $primaryKey = 'id';
    protected $fillable = [
        'product_id',
        'sku_code',
        'price',
        'stock',
        'image',
        'album',
        'promotion_price',
        'json_data'
    ];

    public static function getAttributeName(){
        return [
           
        ];
    }
}

