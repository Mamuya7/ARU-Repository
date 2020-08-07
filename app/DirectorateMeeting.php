<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DirectorateMeeting extends Model
{
    protected $fillable = ["meeting_id","directorate_id"];
    
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
}
