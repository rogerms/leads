<?php

namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'date_sold'];
	public function lead()
	{
    	return $this->belongsTo("App\Lead");
  	}

  	public function notes()
    {
        return $this->hasMany('App\Note')->withTrashed()->orderBy('created_at', 'desc');
    }

    public function features()
    {
        return $this->belongsToMany('App\Feature')->withPivot('feature_id', 'active');
    }

    public function stylegroups()
    {
        return $this->hasMany('App\StyleGroup');
    }

    public function removals()
    {
        return $this->hasMany('App\Removal');
    }

    public function materials()
    {
        return $this->hasMany('App\Material');
    }
}
