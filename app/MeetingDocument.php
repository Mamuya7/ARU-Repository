<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MeetingDocument extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'meeting_id', 'document_id',
    ];
}
