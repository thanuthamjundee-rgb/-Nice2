<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Repair extends Model
{
    protected $table = 'repair';
    protected $primaryKey = 'id';
    protected $fillable = [
    'u_id',
    'eq_id',
    'r_name',
    'r_serialnumber',
    'r_detail',
    'build_id',
    'floor',
    'room',
    's_id',
    'head_id',
    'technician_id',
    'r_date'
];

    public $timestamps = false;
}
