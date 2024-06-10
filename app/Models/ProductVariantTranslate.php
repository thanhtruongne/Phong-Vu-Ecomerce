<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariantTranslate extends Model
{
    use HasFactory;
    
    protected $table = 'product_variant_translate';
    protected $fillable = ['product_variant_id','languages_id','name']; 
    public $timestamps = true;
    
    
}
