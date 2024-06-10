<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttributeTranslate extends Model
{
    use HasFactory;
    protected $table = 'attribute_translate';
    protected $fillable = ['attribute_id','languages_id','name','content','description','meta_title','meta_desc','meta_keyword','meta_link'];

}
