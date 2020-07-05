<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meetings extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'meeting_title', 'meeting_description', 'document_id',
    ];

    protected $members = null;

    public function userRoles()
    {
        return $this->belongsToMany('App\UserRoles','meeting_members','meeting_id','member_role_id')
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
