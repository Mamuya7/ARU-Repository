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
        'role_name',
    ];

    public function users()
    {
        return $this->belongsToMany('App\User','user_roles','role_id','user_id')
                    ->withPivot('id')
                    ->withTimestamps();
    }
}
