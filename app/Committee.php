<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Committee extends Model
{
    protected $fillable = [
        'committee_name', 'committee_code'
    ];

    public function roles()
    {
        return $this->hasMany('App\Roles');
    }
    public function meeting()
    {
        return $this->belongsToMany('App\Meeting','committee_meeting','committee_id','meeting_id');
    }
}
