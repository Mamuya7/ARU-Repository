<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DateTime;

class Meeting extends Model
{
    
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'meeting_title', 'meeting_description', 'meeting_type', 'meeting_date',
    ];

    public function __construct()
    {
       
    }
    // meetings eloquent relationship methods
    public function departments()
    {
        return $this->belongsToMany('App\Department','department_meeting','meeting_id','department_id')
                    ->withPivot('meeting_id','department_id','secretary_id');
    }
    public function school()
    {
        return $this->belongsToMany('App\School','school_meetings','meeting_id','school_id');
    }
    public function directorates()
    {
        return $this->belongsToMany('App\Directorate','directorate_meeting','meeting_id','directorate_id');
    }
    public function committee()
    {
        return $this->belongsToMany('App\Committee','committee_meeting','meeting_id','committee_id');
    }
    public function departmentMeetings()
    {
        return $this->hasMany('App\DepartmentMeeting');
    }
    public function schoolMeetings()
    {
        return $this->hasMany('App\SchoolMeeting');
    }
    public function directorateMeetings()
    {
        return $this->hasMany('App\DirectorateMeeting');
    }

    // checking meetings type methods
    public function ofDepartment()
    {
        if($this->meeting_type === 'department'){
            return true;
        }
        return false;
    }
    public function ofCouncil()
    {
        if($this->meeting_type === 'council'){
            return true;
        }
        return false;
    }
    public function ofBoard()
    {
        if($this->meeting_type === 'board'){
            return true;
        }
        return false;
    }
    public function ofSchool()
    {
        if($this->meeting_type === 'school'){
            return true;
        }
        return false;
    }
    public function ofCommittee()
    {
        if($this->meeting_type === 'committee'){
            return true;
        }
        return false;
    }
    public function ofDirectorate()
    {
        if($this->meeting_type === 'directorate'){
            return true;
        }
        return false;
    }
    public function wasHeld()
    {
        $meetingdate = new DateTime($this->meeting_date);
        $todaydate = new DateTime(date('Y-m-d'));
        if($meetingdate < $todaydate){
            return true;
        }
        return false;
    }
    public function getChairman()
    {
        if($this->ofDepartment())
        {
            foreach (Auth::User()->department->users as $user) {
                $member = User::find($user->id);
                if($member->userhasRoleType('head')){
                    return $user;
                }
            }
        }
        return null;
    }

    public function getSecretary()
    {
        if($this->ofDepartment())
        {
            foreach (Auth::User()->department->users as $user) {
                if($user->id === $this->departments()->where('department_id',Auth::User()->department_id)->first()->pivot->secretary_id){
                    return $user;
                }
            }
        }
        return null;
    }
}
