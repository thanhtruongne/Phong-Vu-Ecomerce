<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    use Cachable;
    protected $table = 'wards';
    protected $primaryKey = 'code';
    protected $fillable = ['name','full_name','code_name','district_code'];

    public function Districts() {
        return $this->belongsTo(District::class,'district_code','code');
    }
}
