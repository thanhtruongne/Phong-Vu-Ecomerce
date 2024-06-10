<?php

namespace App\Models;

use App\Trait\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Permissions extends Model
{
    use HasFactory,QueryScopes;
    
    protected $table = 'permissions';
    protected $primaryKey = 'id';
    protected $fillable = ['name','canonical'];

    public function permissions() {
        return $this->belongsToMany(UserCataloge::class,'user_cataloge_permissions','permission_id','user_cataloges_id');
    }
    
}
