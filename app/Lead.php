<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'appointment'];
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
        return $this->hasMany('App\Note')->withTrashed()->orderBy('created_at', 'desc');
    }

    public function jobs()
    {
        return $this->hasMany('App\Job')->orderBy('created_at', 'desc');
    }

    public function drawings()
    {
        return $this->hasMany('App\Drawing')->orderBy('created_at', 'asc');
    }

    public function phones()
    {
        return $this->hasMany('App\Phone');
    }

    public function labels()
    {
        return $this->belongsToMany('App\Label', 'lead_label')
            ->withPivot('id')
            ->wherePivot('deleted_at', null)
            ->withTimestamps();
    }
}
