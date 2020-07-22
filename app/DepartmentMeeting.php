<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DepartmentMeeting extends Model
{
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

    protected $meeting;
    protected $secretary;

    public function __construct($meeting)
    {
        $this->meeting = $meeting;
        $this->secretary = DepartmentMeeting::where('meeting_id',$this->meeting)
                            ->where('department_id',Auth::User()->department_id)->first();
    }

    public function getDepartmentSecretary()
    {
        return $this->secretary;
    }
}
