<?php
namespace App\Models;

use App\Trait\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;
class ProductCateloge extends Model
{
    use HasFactory;
    use QueryScopes,NodeTrait;
    
    protected $table = 'product_cateloge';
    protected $primaryKey = 'id';
    //dạng fillable mặc định cho model cataloge
    protected $fillable = ['image','icon','album','status','order','user_id','follow','parent','LEFT','RIGHT','attributes',
    'name','content','desc','meta_title','meta_desc','meta_keyword','canonical'
    ];

    protected $casts = [
        'attributes' => 'json'
    ];
    

    public function products() {
        return $this->belongsToMany(Product::class,'product_cateloge_product','product_cateloge_id','product_id');
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