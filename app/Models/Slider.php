<?php

namespace App\Models;

use App\Trait\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model
{
    use HasFactory,QueryScopes;
    protected $table = 'slider';
    protected $primaryKey = 'id';
    protected $fillable = ['name','content','keyword','desc','item','setting','short_code','status'];

}
