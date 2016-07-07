<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    protected $table = 'lead_phones';

    public function lead()
    {
        return $this->belongsTo('App\Lead');
    }
}
