<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use Cachable;

    protected $table = 'districts';
    protected $primaryKey = 'code';
    protected $fillable = ['name','full_name'];
    public $incrementing = false;
    public function Provinces() {
        return $this->belongsTo(Province::class,'province_code','code');
    }

    public function Ward() {
        return $this->hasMany(Ward::class,'district_code','code');
    }
}
