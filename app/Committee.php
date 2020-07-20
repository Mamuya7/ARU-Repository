<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Committee extends Model
{
    protected $fillable = [
        'committee_name', 'committee_code'
    ];

    public function roles()
    {
        return $this->hasMany('App\Roles');
    }
}
