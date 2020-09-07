<?php

namespace App\Http\Controllers;

use Auth;
use App\Meeting;
use App\Document;
use App\SchoolMeeting;
use App\DepartmentMeeting;
use App\DirectorateMeeting;
use Illuminate\Http\Request;

class DocumentsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Meeting $meeting)
    {
        if($request->hasFile('file-upload')){
            $dir = 'public/documents/';
            $filetype = $request->input('file-type');
            $ext = $request->file('file-upload')->extension();

            $path = $request->file('file-upload')->store($dir.$filetype);

            if($path !== null){
                $document = $this->create_document([
                    "type" => $filetype,
                    "path" => $path,
                    "extension" => $ext]);
                
                if($meeting->ofDepartment()){
                    $departmentMeeting = DepartmentMeeting::where('meeting_id',$meeting->id)
                                        ->where(function($query){
                                                $query->where('department_id',Auth::User()->department_id);
                                        })->get();
                    $departmentMeeting->first()->documents()->save($document);
                }elseif ($meeting->ofDirectorate()) {
                    $dir_id = Auth::User()->directorate()->id;
                    $directorateMeeting = DirectorateMeeting::where('meeting_id',$meeting->id)
                                        ->where(function($query)use($dir_id){
                                            $query->where('directorate_id',$dir_id);
                                        })->get();
                    $directorateMeeting->first()->documents()->save($document);
                }elseif ($meeting->ofSchool()) {
                    $school_id = Auth::User()->school()->id;
                    $schoolMeeting = SchoolMeeting::find($school_id)->where('meeting_id',$meeting->id)
                                        ->where(function($query)use($school_id){
                                            $query->where('school_id',$school_id);
                                        })->get();
                    $schoolMeeting->first()->documents()->save($document);
                }elseif ($meeting->ofCommittee()) {
                    # code...
                }
            }
        }

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Documents  $documents
     * @return \Illuminate\Http\Response
     */
    public function show(Documents $documents)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Documents  $documents
     * @return \Illuminate\Http\Response
     */
    public function edit(Documents $documents)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Documents  $documents
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Documents $documents)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Documents  $documents
     * @return \Illuminate\Http\Response
     */
    public function destroy(Documents $documents)
    {
        //
    }

    protected function create_document($docInfo){
        $document = new Document([
            'document_name' => "",
            'document_type' => $docInfo["type"],
            'document_url' => $docInfo["path"],
            'document_extension' => $docInfo["extension"]
        ]);
        return $document;
    }
}
