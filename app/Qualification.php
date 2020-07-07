<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Qualification extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'code',
    ];

    public function meetings()
    {
        return $this->belongsToMany('App\Meetings','meeting_qualifications','qualification_id','meeting_id');
    }

}
