<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolMeeting extends Model
{
    protected $fillable = ["meeting_id","school_id"];
    
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
}
