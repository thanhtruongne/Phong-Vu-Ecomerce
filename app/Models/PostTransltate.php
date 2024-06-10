<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostTransltate extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'post_translate';
    protected $fillable = ['post_id','language_id','name','content','desc','meta_title','meta_desc','meta_keyword','meta_link'];

}
