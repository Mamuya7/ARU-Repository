<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRoles extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','user_id','role_id',
    ];

    public function userRoles()
    {
        return $this->belongsToMany('App\Meetings','meeting_members','member_role_id','meeting_id')
                    ->withPivot('id');
    }
}
