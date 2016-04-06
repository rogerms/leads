<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends Model
{
	use SoftDeletes;

	protected $dates = ['deleted_at'];

	public function lead()
	{
    	return $this->belongsTo("App\Lead");
  	}

  	public function job()
	{
    	return $this->belongsTo("App\Job");
  	}
}
