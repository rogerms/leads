<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $table = 'lead_emails';

    public function lead()
    {
        return $this->belongsTo('App\Lead');
    }
}
