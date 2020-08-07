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

    public static function getDepartmentSchoolId($dep_id)
    {
        $dep = DepartmentSchool::find($dep_id);
        return $dep->school_id;
    }
}
