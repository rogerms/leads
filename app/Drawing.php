<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Drawing extends Model
{
    protected $table = 'drawings';

    public function lead()
    {
        return $this->belongsTo('App\Lead');
    }

    public function scopeSelected($query)
    {
        return $query->where('selected', '=', true);
    }
}
