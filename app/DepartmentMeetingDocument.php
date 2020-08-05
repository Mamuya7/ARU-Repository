<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DepartmentMeetingDocument extends Model
{
    protected $fillable = [
        'department_meeting_id',
        'document_id',
    ];

    public static function storeDocument($department_meeting_id, $document_id)
    {
        $meeting = new DepartmentMeeting();
        $meeting->department_meeting_id = $department_meeting_id;
        $meeting->document_id = $document_id;
        $meeting->save();

    }
}
