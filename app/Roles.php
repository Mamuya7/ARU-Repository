<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_name', 'role_code','role_type'
    ];


    public function committees()
    {
        return $this->belongsToMany('App\Committee','committee_role','role_id','committee_id');
    }


    public function user()
    {
        return $this->belongsToMany('App\User','role_user','role_id','user_id')
                    ->withPivot('id')
                    ->withTimestamps();
    }

    public function meetings()
    {
        return $this->belongsToMany('App\Meeting','meeting_roles','role_id','meeting_id')
                    ->withPivot('id');
    }
}
