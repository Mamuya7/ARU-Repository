<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Committee extends Model
{
    protected $fillable = [
        'committee_name', 'committee_code'
    ];

    // public function roles()
    // {
    //     return $this->hasMany('App\Roles');
    // }

    public function roles()
    {
        // return $this->hasMany('App\Roles');
        return $this->belongsToMany('App\Roles','committee_role','committee_id','role_id')
                    ->withPivot('id','committee_id','role_id','position');
    }


    public function meeting()
    {
        return $this->belongsToMany('App\Meeting','committee_meetings','committee_id','meeting_id')
                    ->withPivot('id as pivot_id','committee_id','meeting_id');
    }

    public function committeeMeetings()
    {
        return $this->hasMany('App\CommitteeMeeting');
    }

    public function users()
    {
        return $this->belongsToMany('App\User','committee_user','committee_id','user_id');
    }

    public function committeeUsers()
    {
        $committee_users = Array();
        $users = User::all();
        $roles = $this->roles;
        foreach ($users as $user) {
            foreach ($roles as $role) {
                if($user->hasRoleCode($role->role_code)){
                    array_push($committee_users,$user);
                    break;
                }
            }
        }

        return $committee_users;
    }
}
