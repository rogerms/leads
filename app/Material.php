<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $table = 'job_materials';
    public $timestamps = false;
    protected $fillable = ['name', 'qty', 'qty_unit', 'job_id'];
}
