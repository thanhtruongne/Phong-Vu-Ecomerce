<?php
namespace App\Models;

use App\Trait\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attribute extends Model
{
    use HasFactory,QueryScopes,SoftDeletes;
    protected $table = 'attribute';
    protected $primaryKey = 'id';
    protected $fillable = ['image','icon','album','status','order','user_id','follow','attribute_cateloge_id'];
    

    public function attribute_cataloge() {
        return $this->belongsTo(AttributeCateloge::class,'attribute_cateloge_id','id');
    }

    public function attribute_translate() {
        //params theo điều kiện
        return $this->hasMany(AttributeTranslate::class,'attribute_id','id');
    }

    public function languages() {
        return $this->belongsToMany(Languages::class,'attribute_translate','attribute_id','languages_id')
        ->withPivot(['name','content','desc','meta_title','meta_keyword','meta_desc','meta_link'])->withTimestamps();
    }

    public function attribute_cateloge_attribute() {
        return $this->belongsToMany(AttributeCateloge::class,'attribute_cateloge_attribute','attribute_id','attribute_cateloge_id');
    }

}

