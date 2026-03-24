<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Level extends Model
{
    protected $table = 'user_level';
    protected $primaryKey = 'id';
    protected $fillable = ['level_name'];
    public $timestamps = false;
}