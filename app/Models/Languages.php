<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Trait\QueryScopes;
class Languages extends Model
{
    use HasFactory, SoftDeletes , QueryScopes;
    
    protected $table = 'languages';
    protected $primaryKey = 'id';
    protected $fillable = ['name','canonical','desc','status','image','user_id','current'];
    
    public $incrementing = false;


    public function languages() {
        return $this->belongsToMany(PostCataloge::class,'post_cateloge_translate','languages_id','post_cateloge_id')
        ->withPivot(['name','content','description','meta_title','meta_keyword','meta_desc','meta_link'])->withTimestamps();
    }

    public function post_cateloges_transltate() {
        return $this->hasMany(PostCatelogeTranslate::class,'languages_id','id');
    }
}
