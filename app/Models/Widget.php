<?php

namespace App\Models;

use App\Trait\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Widget extends Model
{
    use HasFactory,QueryScopes;
    protected $table = 'widget';
    protected $primaryKey = 'id';
    protected $fillable = ['name','keyword','content','desc','model_id','album','model','short_code'];
    protected $casts = [
        'model_id' => 'json',
        'album' => 'json'
    ];
}
