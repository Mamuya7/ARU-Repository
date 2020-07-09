<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schools extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'school_name', 'school_code',
    ];
}
