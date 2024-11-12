<?php
namespace  Modules\Widget\Entities;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class Widget extends Model
{
    use Cachable;
    
    protected $table = 'widget';
    protected $primaryKey = 'id';

    protected $fillable = ['name','keyword','content','model_id','count','code','banner'];

    protected $casts = [
        'model_id' => 'json'
    ]

}