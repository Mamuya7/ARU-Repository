<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommitteeRole extends Model
{
    public $table = "committee_role";
    
    protected $fillable = [
        'role_id', 'committee_id'
    ];

}
