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
    protected $fillable = ['image','icon','album','status','order','user_id','follow','post_cateloge_id',
    'name','content','desc','meta_title','meta_desc','meta_keyword','canonical'
    ];
    

    public function post_cataloge() {
        return $this->belongsTo(PostCataloge::class,'post_cateloge_id','id');
    }

    public function post_cateloge_post() {
        return $this->belongsToMany(PostCataloge::class,'post_cateloge_post','post_id','post_cateloge_id');
    }

}
