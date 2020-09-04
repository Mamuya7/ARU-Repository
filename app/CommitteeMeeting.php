<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommitteeMeeting extends Model
{
    protected $fillable = ["meeting_id","committee_id"];
    
    public function meeting()
    {
        return $this->belongsTo('App\Meeting');
    }
    public function committee()
    {
        return $this->belongsTo('App\Committee');
    }
    public function documents()
    {
        return $this->morphMany('App\Document','documentable');
    }
    public function attendences()
    {
        return $this->morphMany('App\Attendence','attendenceable');
    }
}
