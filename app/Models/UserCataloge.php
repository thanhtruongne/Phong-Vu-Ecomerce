<?php

namespace App\Models;

use App\Trait\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserCataloge extends Model
{
    use HasFactory;
    use SoftDeletes,QueryScopes;

    protected $table = 'user_cataloges';

    protected $primaryKey = 'id';

    protected $fillable = ['name','desc','status'];
    public function users() {
       return  $this->hasMany(User::class,'user_cataloges_id','id');
    }

    public function permissions() {
        return $this->belongsToMany(Permissions::class,'user_cataloge_permissions','user_cataloges_id','permission_id');
    }

}
