<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DirectorateMeeting extends Model
{
    public $table = "directorate_meetings";
    
    protected $fillable = ["meeting_id","directorate_id","secretary_id","meeting_time"];
    
    public function meeting()
    {
        return $this->belongsTo('App\Meeting');
    }

    public function documents()
    {
        return $this->morphMany('App\Document','documentable');
    }
    public function attendences()
    {
        return $this->morphMany('App\Attendence','attendenceable');
    }
    public function invitations()
    {
        return $this->morphMany('App\Invitation','invitationable');
    }
    public function boardMembers()
    {
        $members = Array();

        foreach (Directorate::find($this->directorate_id)->departments as $department) {
            foreach ($department->users as $user) {
                if($user->hasRoleType('head')){
                    array_push($members,$user);
                }elseif($user->hasRoleType('director')){
                    array_push($members,$user);
                }
            }
        }

        return $members;
    }
}
