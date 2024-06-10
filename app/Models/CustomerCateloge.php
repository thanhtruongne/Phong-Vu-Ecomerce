<?php

namespace App\Models;

use App\Trait\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerCateloge extends Model
{
    use HasFactory,QueryScopes;

    protected $table = 'customer_cateloge';

    protected $primaryKey = 'id';
    protected $attributes = [
        'status' => 1
     ];
    protected $fillable = ['name','desc','status','keyword'];
    public function customer() {
       return  $this->hasMany(Customer::class,'customer_cateloge_id','id');
    }


}
