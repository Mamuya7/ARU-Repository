<?php

namespace App;

use Auth;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name','last_name', 'username','gender', 'email', 'password', 'department_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles()
    {
        return $this->belongsToMany('App\Roles','role_user','user_id','role_id')
                    ->withPivot('id')
                    ->withTimestamps();
    }

    public function committees()
    {
        return $this->belongsToMany('App\Committee','committee_user','user_id','committee_id');
    }

    public function hasRole($role)
    {
        foreach (Auth::User()->roles as $value) {
            if($value->role_name === $role){
                return true;
            }
        }
        return false;
    }

    public function userHasRole( $role)
    {
        foreach ($this->roles as $value) {
            if($value->role_name === $role){
                return true;
            }
        }
        return false;
    }

    public function hasBothRoles($role1,$role2)
    {
        $r1 = false; $r2 = false;
        foreach (Auth::User()->roles as $value) {
            if($value->role_name === $role1){
                $r1 = true;
            }
            if($value->role_name === $role2){
                $r2 = true;
            }
        }

        return ($r1 && $r2);
    }

    public function hasAnyRole($roles)
    {
        foreach (Auth::User()->roles as $value) {
            foreach ($roles as $role) {
                if($value->role_name === $role){
                    return true;
                }
            }
        }
        return false;
    }

    public function school()
    {
        return Auth::User()->department->school;
    }

    public function department()
    {
        return $this->belongsTo('App\Department');
    }
    // public function department()
    // {
    //     $department = new Department();
    //     $department->setId(Auth::User()->department_id);
    //     return $department;
    // }
}
