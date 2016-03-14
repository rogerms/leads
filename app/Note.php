<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
	public function lead()
	{
    	return $this->belongsTo("App\Lead");
  	}

  	public function job()
	{
    	return $this->belongsTo("App\Job");
  	}
}
