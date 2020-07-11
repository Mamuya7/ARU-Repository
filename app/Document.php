<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'document_type', 'document_url',
    ];

    public function meetings()
    {
        return $this->belongsToMany('App\Meetings','meeting_documents','document_id','meeting_id');
    }

}