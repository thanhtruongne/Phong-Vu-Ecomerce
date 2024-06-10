<?php
namespace App\Models;

use App\Trait\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromotionProductVariant extends Model
{
    use HasFactory,QueryScopes;
    protected $table = 'promotion_product_variant';

    protected $fillable = [
        'promotion_id',
        'product_id',
        'model',
        'product_variant_id',    
    ];

    

}

