<?php
namespace App\Models;

use App\Trait\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;
class AttributeCateloge extends Model
{
    use HasFactory,QueryScopes,NodeTrait;
    
    protected $table = 'attribute_cateloge';
    protected $primaryKey = 'id';
    //dạng fillable mặc định cho model cataloge
    protected $fillable = ['image','album','status','parent','LEFT','RIGHT',
    'name','content','desc','meta_title','meta_desc','meta_keyword','canonical'
];
    

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