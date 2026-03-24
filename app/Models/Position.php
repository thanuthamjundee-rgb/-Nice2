<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $table = 'Position';
    protected $primaryKey = 'id';
    protected $fillable = ['position_name'];
    public $timestamps = false;
}
