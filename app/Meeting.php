<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

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

    protected $members = null;

    public function __construct()
    {
       
    }

    public function departments()
    {
        return $this->belongsToMany('App\Department','department_meeting','meeting_id','department_id')
                    ->withPivot('meeting_id','department_id','secretary_id');
    }
    public function school()
    {
        return $this->belongsToMany('App\School','school_meeting','meeting_id','school_id');
    }
    public function committee()
    {
        return $this->belongsToMany('App\Committee','committee_meeting','meeting_id','committee_id');
    }
    public function setMembers($value)
    {
        $this->members = $value;
    }

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
        if($this->meeting_date < date('Y-m-d')){
            return true;
        }
        return false;
    }
    public function getChairman()
    {
        if($this->ofDepartment() && ($this->members !== null))
        {
            foreach ($this->members as $member) {
                $user = User::find($member->id);
                if($user->userHasRole('head')){
                    return $member;
                }
            }
        }
        return null;
    }

    public function getSecretary()
    {
        if($this->ofDepartment() && ($this->members !== null))
        {
            foreach ($this->members as $member) {
                if($member->id === $this->departments()->where('department_id',Auth::User()->department_id)->first()->pivot->secretary_id){
                    return $member;
                }
            }
        }
        return null;
    }
}
