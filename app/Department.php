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
        'department_name', 'department_code', 'departmentable_id', 'departmentable_type',
    ];

    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function departmentable()
    {
        return $this->morphTo();
    }
    public function meetings()
    {
        return $this->belongsToMany('App\Meeting','department_meeting','department_id','meeting_id')
                    ->withPivot('id as pivot_id','department_id','meeting_id');
    }

    //logical functions
    public function belongsToSchool()
    {
        if($this->departmentable->getMorphClass() == School::class){
            return true;
        }
        return false;
    }

    public function belongsToDirectorate()
    {
        if($this->departmentable->getMorphClass() == Directorate::class){
            return true;
        }
        return false;
    }
}
