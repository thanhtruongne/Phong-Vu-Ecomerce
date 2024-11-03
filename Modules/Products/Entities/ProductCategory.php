<?php
namespace  Modules\Products\Entities;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;
class ProductCategory extends Model
{
    use NodeTrait;
    
    protected $table = 'product_category';
    protected $primaryKey = 'id';
    protected $fillable = ['description','icon','status','parent_id','_lft','_rgt','name','ikey'];

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
            'name' => 'Tên danh mục sản phẩm',
            'status' => 'Trạng thái sản phẩm',
            'description' => 'Mô tả sản phẩm'
        ];
    }
}