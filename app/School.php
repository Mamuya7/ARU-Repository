<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'school_name', 'school_code',
    ];

    // protected $id;
    // protected $department_id;
    /**
     * Create a new model instance.
     *
     * @return void
     */
    // public function __construct($department)
    // {
    //     setDepartmentId($department);
    // }

    // public function setDepartmentId($department)
    // {
    //     $this->department_id = $department;
    // }

    // public function getDepartmentId()
    // {
    //     return $this->department_id;
    // }

    // public function getId()
    // {
    //     return $this->id;
    // }

    // public function departments()
    // {
    //     return $this->belongsToMany('App\Department','department_school','school_id','department_id');
    // }
}
