<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Department extends Model
{
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     *
     */

   
    protected $fillable = [
        'department_name', 'department_code',
    ];

    protected $id;

    /**
     * Create a new model instance.
     *
     * @return void
     */
    
    public function __construct($id)
    {
        $this->id = $id;
    }

    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function departmentSchool()
    {
        return new DepartmentSchool($this->getId());
    }
     public function departmentUsers()
     {
        return User::where('department_id',$this->id);
     }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }
}
