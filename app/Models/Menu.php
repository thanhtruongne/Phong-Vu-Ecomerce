<?php

namespace App\Models;

use App\Trait\QueryScopes;
use Carbon\Language;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;

class Menu extends Model
{
    use HasFactory,SoftDeletes,QueryScopes,NodeTrait;
    protected $table = 'menu';
    protected $primaryKey = 'id';
    protected $fillable = ['image','album','status','order','user_id','type','menu_cateloge_id','position','LEFT','RIGHT','parent'];
    
    protected $casts = [

    ];

    public function languages() {
        return $this->belongsToMany(Languages::class,'menu_translate','menu_id','language_id')
        ->withPivot(['name','canonical'])->withTimestamps();
    }
    

    public function menu_cateloge() {
        return $this->belongsTo(MenuCateloge::class,'menu_cateloge_id','id');
    }

    public function menu_translate() {
        return $this->hasMany(MenuTranslate::class,'menu_id','id');
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
