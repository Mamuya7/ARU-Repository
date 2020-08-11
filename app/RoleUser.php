<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public $table = "role_user";
    protected $fillable = [
        'id','user_id','role_id',
    ];
}
