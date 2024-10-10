<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use Cachable;

    
    protected $table = 'provinces';
    protected $primaryKey = 'code';
    protected $fillable = ['name','full_name'];
    
    public $incrementing = false;

    public function districts() {
        return $this->hasMany(District::class,'province_code','code');
    }
}
