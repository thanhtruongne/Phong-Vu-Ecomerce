<?php
namespace App\Models;

use App\Trait\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;
class AttributeCateloge extends Model
{
    use HasFactory,QueryScopes,NodeTrait,SoftDeletes;
    
    protected $table = 'attribute_cateloge';
    protected $primaryKey = 'id';
    //dạng fillable mặc định cho model cataloge
    protected $fillable = ['image','icon','album','status','order','user_id','follow','parent','LEFT','RIGHT'];
    

    public function languages() {
        return $this->belongsToMany(Languages::class,"attribute_cateloge_translate","attribute_cateloge_id",'languages_id')
        ->withPivot(['name','content','desc','meta_title','meta_keyword','meta_desc','meta_link'])->withTimestamps();
    }

    public function attribute_cateloge_translate() {
        return $this->hasOne(AttributeCatelogeTranslate::class,'attribute_cateloge_id','id');
    }

    public function getLftName()
    {
        return 'LEFT';
    }

    public function getRgtName()
    {
        return 'RIGHT';
    }

    public function getParentIdName()
    {
        return 'parent';
    }

    // Specify parent id attribute mutator
    public function setParentAttribute($value)
    {
        $this->setParentIdAttribute($value);   
    }
}