<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommitteeUser extends Model
{
   public $table = "committee_user";
    
    protected $fillable = [
        'user_id', 'committee_id'
    ];

}
