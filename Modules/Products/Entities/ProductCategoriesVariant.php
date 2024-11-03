<?php
namespace  Modules\Products\Entities;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;


class ProductCategoriesVariant extends Model
{
    use Cachable;
    
    protected $table = 'product_categories_variant';
    protected $primaryKey = 'id';
    protected $fillable = ['product_cateloge_id','sku_id'];
}