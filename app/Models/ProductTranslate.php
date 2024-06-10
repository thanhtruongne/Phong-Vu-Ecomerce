<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductTranslate extends Model
{
    use HasFactory;
    
    protected $table = 'product_translate';
    protected $fillable = ['product_id','languages_id','name','content','description','meta_title','meta_desc','meta_keyword','meta_link'];

}
