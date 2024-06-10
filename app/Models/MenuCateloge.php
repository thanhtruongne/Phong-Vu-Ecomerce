<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Trait\QueryScopes;
class MenuCateloge extends Model
{
    use HasFactory , QueryScopes;
    
    protected $table = 'menu_cateloge';
    protected $primaryKey = 'id';
    protected $fillable = ['name','keyword','status','user_id'];

    public function menu() {
        return $this->hasMany(Menu::class,'menu_cateloge_id','id');
    }

    


}
