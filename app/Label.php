<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    protected $table = 'labels';
    protected $fillable = ['name', 'type', 'display_order'];

    public function scopeJob($query)
    {
        return $query->where('type', 'job')->orderBy('display_order', 'asc');
    }

    public function scopeLead($query)
    {
        return $query->where('type', 'lead')->orderBy('display_order');
    }

    public function jobs()
    {
        return $this->belongsToMany('App\Job', 'job_label')
            ->withPivot('id')
            ->wherePivot('deleted_at', null)
            ->withTimestamps();
    }

    public function leads()
    {
        return $this->belongsToMany('App\Lead', 'lead_label')
            ->withPivot('id')
            ->wherePivot('deleted_at', null)
            ->withTimestamps();
    }
}
