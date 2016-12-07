<?php

namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Job extends Model
{
    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'date_sold'];
	public function lead()
	{
    	return $this->belongsTo("App\Lead");
  	}

  	public function notes()
    {
        return $this->hasMany('App\Note')
            ->where('is_personal', false)
            ->withTrashed()
            ->orderBy('created_at', 'desc');
    }

    public function personal_notes()
    {
        return $this->hasMany('App\Note')
            ->where('user_id', Auth::user()->id)
            ->withTrashed()
            ->orderBy('created_at', 'desc');
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

    public function proposal()
    {
        return $this->hasOne('App\Proposal')->orderBy('created_at', 'desc');
    }

    public function proposals()
    {
        return $this->hasMany('App\Proposal')->withTrashed()->orderBy('created_at', 'desc');
    }

    public function labels()
    {
        return $this->belongsToMany('App\Label')
            ->withPivot('id')
            ->wherePivot('deleted_at', null)
            ->withTimestamps();
    }
}
