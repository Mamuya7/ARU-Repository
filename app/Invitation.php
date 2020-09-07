<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    /**
   * The attributes that are mass assignable.
   *
   * @var array
   *
   */

  protected $fillable = [
      'user_id','role_id','invitationable_id', 'invitationable_type',
  ];

  public function invitationable()
  {
      return $this->morphTo();
  }
  
  public function user()
  {
      return $this->belongsTo('App\User');
  }
}
