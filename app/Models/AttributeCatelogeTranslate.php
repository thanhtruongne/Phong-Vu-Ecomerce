<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttributeCatelogeTranslate extends Model
{
    use HasFactory;
    
    protected $table = 'attribute_cateloge_translate';
    protected $fillable = ['attribute_cateloge_id','languages_id','name','content','desc','meta_title','meta_desc','meta_keyword','meta_link'];

}
