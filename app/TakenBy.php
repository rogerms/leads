<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TakenBy extends Model
{
	protected $table = 'taken_by';
	//** OR 
/*	
	function __construct()
	{
		$this->setTable('taken_by');
	}
	*/
}
