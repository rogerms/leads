<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaverGroup extends Model
{
    public function pavers()
    {
        return $this->hasMany('App\Paver', 'group_id');
    }

    public function job()
    {
        return $this->belongsTo('App\Job');
    }
}
