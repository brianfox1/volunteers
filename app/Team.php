<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $primaryKey = 'project_id';
    public $incrementing = false;
    protected $table = 'teams';

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
