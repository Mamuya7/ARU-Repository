<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Department extends Model
{
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     *
     */

   
    protected $fillable = [
        'department_name', 'department_code',
    ];
    /**
     * Create a new model instance.
     *
     * @return void
     */
    
    public function __construct()
    {
        
    }

    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function school()
    {
        return $this->belongsToMany('App\School','department_school','department_id','school_id')
                    ->withPivot('school_id','department_id');
    }
    public function meetings()
    {
        return $this->belongsToMany('App\Meeting','department_meeting','department_id','meeting_id')
                    ->withPivot('department_id','meeting_id','secretary_id');
    }
}
