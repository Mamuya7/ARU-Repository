<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departments extends Model
{
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     *
     */

   
    protected $fillable = [
        'department_name', 'department_code', 'school_id'
    ];

    public function users()
    {
        return $this->hasMany('App\User');
    }
}
