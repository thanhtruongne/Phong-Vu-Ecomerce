<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    protected $table = 'address_districts';
    protected $primaryKey = 'code';
    protected $fillable = ['name'];
    public $incrementing = false;
    public function Provinces() {
        return $this->belongsTo(Province::class,'province_code','code');
    }

    public function Ward() {
        return $this->hasMany(Ward::class,'district_code','code');
    }
}
