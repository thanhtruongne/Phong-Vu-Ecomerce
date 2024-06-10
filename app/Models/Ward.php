<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    use HasFactory;
    protected $table = 'address_wards';

    protected $fillable = ['code','name','full_name','code_name','district_code'];

    public function Districts() {
        return $this->belongsTo(District::class,'district_code','code');
    }
}
