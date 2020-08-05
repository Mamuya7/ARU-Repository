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
        'document_name','document_type', 'document_url', 'documentable_id', 'documentable_type',
        'document_extension',
    ];

    public function documentable()
    {
        return $this->morphTo();
    }
    public function departmentMeeting()
    {
        return $this->belongsTo('App\DepartmentMeeting','department_meeting_documents','document_id','department_meeting_id')
                    ->witPivot('department_meeting_id','document_id');
    }
    public function icon($extension)
    {
        $path = "img/icons/";
        if($extension === "pdf"){
            $path = asset($path."pdf-round.png");
        }elseif (($extension === "doc") || ($extension === "docx")){
            $path = asset($path."word-round.png");
        }elseif (($extension === "xls") || ($extension === "xlsx") || ($extension === "csv")) {
            $path = asset($path."excel-round.png");
        }else{
            $path = asset($path."doc.png");
        }
        return $path;
    }

}