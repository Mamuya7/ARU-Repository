<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MeetingMembers extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'meeting_id', 'member_role_id', 'position',
    ];
}
