<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostCatalogePost extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'post_cataloges_post';
    protected $fillable = ['post_catelogues_id','post_id'];
    
    public function post_cataloge() {
        return $this->hasMany(PostCataloge::class,'post_catelogues_id','id');
    }
}
