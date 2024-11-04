<?php
namespace  Modules\Products\Entities;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;


class Attribute extends Model
{
    use NodeTrait;
    
    protected $table = 'attributes';
    protected $primaryKey = 'id';
    //dạng fillable mặc định cho model cataloge
    protected $fillable = ['image','icon','status','parent_id','_lft','_rgt','name'];

    public function products(){
        return $this->belongsToMany(Products::class,'product_attribute_relation','attribute_id','product_id');
    }

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


    public static function getAttributeName(){
        return [
            'name' => 'Tên thuộc tính',
            'status' => 'Trạng thái thuộc tính'
        ];
    }

}