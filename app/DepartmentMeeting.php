<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DepartmentMeeting extends Model
{
    public $table = 'department_meeting';
    public static $TABLE_NAME = 'department_meeting';
    
    protected $fillable = [
        'department_id',
        'meeting_id',
        'secretary_id',
        'meeting_time',
    ];

    public static $DEPARTMENT_ID = 'department_id';
    public static $MEETING_ID = 'meeting_id';
    public static $SECRETARY_ID = 'secretary_id';
    public static $MEETING_TIME = 'meeting_time';

    
    public function meeting()
    {
        return $this->belongsTo('App\Meeting');
    }

    public function documents()
    {
        return $this->morphMany('App\Document','documentable');
    }

}
