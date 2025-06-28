<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    use Cachable;

    protected $table = 'wards';
    protected $primaryKey = 'code';
    protected $fillable = ['name', 'fullName'];
    public $incrementing = false;


    public function Provinces()
    {
        return $this->belongsTo(Province::class, 'provinceCode', 'code');
    }
}
