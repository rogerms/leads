<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    
    public function source()
    {
        return $this->belongsTo('App\Source');
    }

    public function takenby()
    {
        return $this->belongsTo('App\TakenBy', 'taken_by_id', 'id');
    }

    public function salesrep()
    {
        return $this->belongsTo('App\SalesRep', 'sales_rep_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo('App\Status');
    }

    public function notes()
    {
        return $this->hasMany('App\Note')->orderBy('created_at', 'desc');
    }

    public function jobs()
    {
        return $this->hasMany('App\Job')->orderBy('created_at', 'desc');
    }

    public function drawings()
    {
        return $this->hasMany('App\Drawing')->orderBy('created_at', 'asc');
    }
}
