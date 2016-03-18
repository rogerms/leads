<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StyleGroup extends Model
{
    public function styles()
    {
        return $this->hasMany('App\Style', 'group_id');
    }

    public function job()
    {
        return $this->belongsTo('App\Job');
    }
}
