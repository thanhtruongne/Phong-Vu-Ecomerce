<?php

namespace App\Models;

use App\Trait\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Source extends Model
{
    use HasFactory,SoftDeletes,QueryScopes;

    protected $table = 'source';

    protected $primaryKey = 'id';

    protected $fillable = ['name','desc','keyword','status'];

    protected $attributes = [
        'status' => 1
    ];

}
