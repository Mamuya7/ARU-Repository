<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'meeting_title', 'meeting_description', 'meeting_date',
    ];

    protected $members = null;

    public function roles()
    {
        return $this->belongsToMany('App\Roles','meeting_roles','meeting_id','role_id')
                    ->withPivot('id');
    }

    public function setMembers($value)
    {
        $this->members = $value;
    }

    public function getChairman()
    {
        // App\Meetings::find($id)->userRoles()->get();
        if($this->members !== null){
            foreach ($this->members as $member) {
                if($member->position === 'chairman'){
                    return $member;
                }
            }
        }
        return null;
    }

    public function getSecretary()
    {
        if($this->members !== null){
            foreach ($this->members as $member) {
                if($member->position === 'secretary'){
                    return $member;
                }
            }
        }
        return null;
    }
}
