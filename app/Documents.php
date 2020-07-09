<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Documents extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'document_type', 'document_url', 'reference_id',
    ];
}
