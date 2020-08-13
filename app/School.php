<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'school_name', 'school_code',
    ];

    public function departments()
    {
        return $this->morphMany('App\Department','departmentable');
    }
    // public function departments()
    // {
    //     return $this->belongsToMany('App\Department','department_school','school_id','department_id')
    //                 ->withPivot('school_id','department_id');
    // }
    public function meeting()
    {
        return $this->belongsToMany('App\Meeting','school_meetings','school_id','meeting_id')
                        ->withPivot('id','school_id','meeting_id');
    }
    public function schoolHeads()
    {

    }
}
