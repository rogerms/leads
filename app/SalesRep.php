<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesRep extends Model
{
    protected $table = 'sales_reps';

    public function lead()
    {
        return $this->hasOne('App\Lead');
    }
}
