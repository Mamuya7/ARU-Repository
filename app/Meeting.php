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

    public function users()
    {
        return $this->belongsToMany('App\User','meeting_boards','meeting_id','member_id')
                    ->withPivot('id','position');
    }

    public function qualifications()
    {
        return $this->belongsToMany('App\Qualification','meeting_qualifications','meeting_id','qualification_id');
    }

    public function roles()
    {
        return $this->belongsToMany('App\Roles','meeting_roles','meeting_id','role_id')
                    ->withPivot('id');
    }

    public function documents()
    {
        return $this->belongsToMany('App\Documents','meeting_documents','meeting_id','document_id');
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
