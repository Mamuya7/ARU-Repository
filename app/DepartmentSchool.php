<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DepartmentSchool extends Model
{
    public $table = 'department_school';
    protected $fillable = [
        'department_id',
        'school_id'
    ];
    
    protected $department_id;
    protected $school_id;

    /**
     * Create a new model instance.
     *
     * @return void
     */
    public function __construct($department_id)
    {
        $this->setDepartmentId($department_id);
        $this->setSchoolId(DepartmentSchool::find($department_id));
    }

    public static function getDepartmentSchoolId($dep_id)
    {
        $dep = DepartmentSchool::find($dep_id);
        return $dep->school_id;
    }
    
    public function setDepartmentId($department_id)
    {
        $this->department_id = $department_id;
    }

    public function setSchoolId($school_id)
    {
        $this->school_id = $school_id;
    }

    public function getSchoolId()
    {
        return $this->school_id;
    }
}
