<?php
namespace  Modules\Menus\Entities;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Menu extends Model
{
    use NodeTrait;
    protected $table = 'menus';
    protected $primaryKey = 'id';
    protected $fillable = [
       'name',
       'status',
       'image',
       'url',
       'sort',
       'menu_cateloge_id'
    ];
    public function getLftName()
    {
        return '_lft';
    }


    public function getRgtName()
    {
        return '_rgt';
    }


    public function getParentIdName()
    {
        return 'parent_id';
    }


    // Specify parent id attribute mutator
    public function setParentAttribute($value)
    {
        $this->setParentIdAttribute($value);   
    }

}

