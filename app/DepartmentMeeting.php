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
    ];

    public static $DEPARTMENT_ID = 'department_id';
    public static $MEETING_ID = 'meeting_id';
    public static $SECRETARY_ID = 'secretary_id';
}
