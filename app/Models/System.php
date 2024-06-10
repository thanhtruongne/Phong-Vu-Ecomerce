<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    use HasFactory;
    protected $table = 'system';
    protected $primaryKey = 'id';
    protected $fillable = ['languages_id','user_id','keyword','content'];
}

