<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'mobile', 'mobile_carrier', 'password', 'mobile_notifications', 'user_level',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = [
        'full_name', 'level', 'r_full_name',
    ];

    public function project()
    {
        return $this->belongsTo('App\Projects');
    }

    public function isAdmin()
    {
        return $this->user_level == 99;
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getRFullNameAttribute()
    {
        return $this->last_name . ', ' . $this->first_name;
    }

    public function level()
    {
        return $this->hasOne('App\User_Level', 'id', 'user_level');
    }
    public function getLevelAttribute()
    {
        return $this->level()->first()->user_level;
    }

    public function scopeOnlyManager($builder)
    {
        $builder->where('user_level', 3);
    }
}
