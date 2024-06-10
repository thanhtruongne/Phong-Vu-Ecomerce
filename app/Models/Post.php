<?php

namespace App\Models;

use App\Trait\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes,QueryScopes;
    protected $table = 'post';
    protected $primaryKey = 'id';
    protected $fillable = ['image','icon','album','status','order','user_id','follow','post_cateloge_id'];
    

    public function post_cataloge() {
        return $this->belongsTo(PostCataloge::class,'post_cateloge_id','id');
    }

    public function post_translate() {
        return $this->hasMany(PostTransltate::class,'post_id','id');
    }

    public function languages() {
        return $this->belongsToMany(Languages::class,'post_translate','post_id','language_id')
        ->withPivot(['name','content','desc','meta_title','meta_keyword','meta_desc','meta_link'])->withTimestamps();
    }

    public function post_cateloge_post() {
        return $this->belongsToMany(PostCataloge::class,'post_cateloge_post','post_id','post_cateloge_id');
    }

}
