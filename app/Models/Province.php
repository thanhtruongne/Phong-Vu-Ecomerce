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
    protected $fillable = ['name', 'fullName'];

    public $incrementing = false;

    public function wards()
    {
        return $this->hasMany(Ward::class, 'provinceCode', 'code');
    }
}
