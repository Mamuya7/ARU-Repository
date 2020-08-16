<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DepartmentMeeting extends Model
{
    public $table = 'department_meeting';
    
    protected $fillable = [
        'department_id',
        'meeting_id',
        'secretary_id',
        'meeting_time',
    ];

    
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
