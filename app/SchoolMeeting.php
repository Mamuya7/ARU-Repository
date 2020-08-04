<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolMeeting extends Model
{
    protected $fillable = ["meeting_id","school_id"];

    public function documents()
    {
        return $this->morphMany('App\Document','documentable');
    }
}
