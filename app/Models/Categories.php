<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kalnoy\Nestedset\NodeTrait;


class Categories extends Model
{
    use NodeTrait;

    protected $table = 'categories';
    protected $table_name = "Danh mục sản phẩm";
    protected $primaryKey = 'id';
    protected $fillable = [
        'parent_id',
        '_lft',
        '_rgt',
        'icon',
        'image',
        'name',
        'status',
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


    public static function rebuildTree($categories,$parent_id = 0){
        if(isset($categories) && count($categories) > 0){
            foreach($categories as $key => $children){
                if($parent_id == $children['parent_id']){
                    $data[] = [
                       'name' => $children['name'],
                       'value' => $children['id'],
                       'children' => count($children['children']) ?  self::rebuildTree($children['children'],$children['id']) : []
                   ];
                }
            }
             
            return  $data;
        }
    }
}
