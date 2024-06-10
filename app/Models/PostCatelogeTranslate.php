<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostCatelogeTranslate extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'post_cateloge_translate';
    protected $fillable = ['post_cateloge_id','languages_id','name','content','description','meta_title','meta_desc','meta_keyword','meta_link'];

}
