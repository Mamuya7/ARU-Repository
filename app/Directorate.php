<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Directorate extends Model
{
    protected $fillable = [
        'directorate_name', 'directorate_code', 'directorate_head'
    ];

    public function departments()
    {
        return $this->morphMany('App\Department','departmentable');
    }
    public function meetings()
    {
        return $this->belongsToMany('App\Meeting','directorate_meetings','directorate_id','meeting_id')
                    ->withPivot('id as pivot_id','directorate_id','meeting_id');
    }
    public function role()
    {
        return $this->belongsTo('App\Roles','directorate_head');
    }

    public static function withDirectorAs($role_code)
    {
        $directorates = Directorate::all();

        foreach ($directorates as $directorate) {
            if($directorate->role['role_code'] === $role_code){
                    return $directorate;
            }
        }

        return null;
    }

    public function director()
    {
        return User::withRoleCode(Roles::find($this->directorate_head)->role_code);
    }
}
