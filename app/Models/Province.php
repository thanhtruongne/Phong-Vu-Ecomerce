<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    
    protected $table = 'address_provinces';
    protected $primaryKey = 'code';
    protected $fillable = ['name'];
    
    public $incrementing = false;

    public function districts() {
        return $this->hasMany(District::class,'province_code','code');
    }
}
