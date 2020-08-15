<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Directorate extends Model
{
    protected $fillable = [
        'directorate_name', 'directorate_code',
    ];

    public function departments()
    {
        return $this->morphMany('App\Department','departmentable');
    }
    public function meetings()
    {
        return $this->belongsToMany('App\Meeting','directorate_meeting','directorate_id','meeting_id');
    }
    public function role()
    {
        return $this->belongsTo('App\Roles','directorate_head');
    }
    
}
