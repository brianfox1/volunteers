<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    protected $table = "projects";

    public function manager()
    {
        return $this->hasOne('App\User', 'id', 'manager_id');
    }

    protected $appends = [
        'is_active',
    ];

    public function type()
    {
        return $this->hasOne('App\ProjectTypes', 'id', 'project_type');
    }

    public function setDeadlineAttribute($value)
    {
        $this->attributes['deadline'] = Carbon::parse($value);
    }

    public function getDeadlineAttribute()
    {
        return Carbon::parse($this->attributes['deadline'])->format('m/d/Y');
    }

    public function getIsActiveAttribute()
    {
        return $retVal = ($this->attributes['active'] == 'Y') ? 'Active' : "Inactive";
    }
}
