<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Directorate extends Model
{
    protected $fillable = [
        'directorate_name', 'directorate_code',
    ];

    public function departments()
    {
        return $this->morphMany('App\Department','departmentable');
    }
}