<?php
namespace App\Models;

use App\Trait\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attribute extends Model
{
    use HasFactory,QueryScopes;
    protected $table = 'attribute';
    protected $primaryKey = 'id';
    protected $fillable = ['image','album','status','attribute_cateloge_id',
'name','content','desc','meta_title','meta_desc','meta_keyword','canonical'
];
    

    public function attribute_cataloge() {
        return $this->belongsTo(AttributeCateloge::class,'attribute_cateloge_id','id');
    }
    public function attribute_cateloge_attribute() {
        return $this->belongsToMany(AttributeCateloge::class,'attribute_cateloge_attribute','attribute_id','attribute_cateloge_id');
    }

}

