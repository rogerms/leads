<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proposal extends Model
{
    protected $table = 'job_proposals';

    use SoftDeletes;

    protected $dates = ['deleted_at', 'created_at', 'updated_at'];//fields treated as dates

    protected $fillable = ['job_id', 'text', 'version', 'created_by'];

    protected $touches = ['job'];

    public function job()
    {
        return $this->belongsTo('App\Job');
    }
}
