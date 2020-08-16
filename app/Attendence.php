<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendence extends Model
{
    protected $fillable = [
        'user_id', 'attendenceable_id','attendenceable_type','status',
    ];

    public function attendenceable()
    {
        return $this->morphTo();
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
