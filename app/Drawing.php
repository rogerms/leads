<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Drawing extends Model
{
    protected $table = 'drawings';

    use SoftDeletes;
    protected $dates = ['deleted_at'];//fields treated as dates

    public function lead()
    {
        return $this->belongsTo('App\Lead');
    }

    public function scopePublic($query)
    {
        return $query->where('visibility', '=', 2);
    }
}
