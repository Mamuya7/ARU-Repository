<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Meeting;
use App\Document;
use App\DepartmentMeeting;
use App\DepartmentSchool;
use App\Department;
use App\Attendence;
use Response;
use Illuminate\Http\Request;

class MeetingsController extends Controller
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
        $result = ['school' => array(), 'department' => array()];
        if(Auth::User()->hasAnyRole(['dean','head'])){
            $result['school'] = DB::table('meetings')
                                ->join('school_meeting','meetings.id','=','school_meeting.meeting_id')
                                ->where('school_meeting.school_id',Auth::User()->department->school[0]->id)
                                ->orderBy('meetings.meeting_date','desc')
                                ->get();
        }
        if(Auth::User()->hasAnyRole(['head','staff'])){
            $result['department'] = DB::table('meetings')
                                    ->join('department_meeting','meetings.id','=','department_meeting.meeting_id')
                                    ->where('department_meeting.department_id',Auth::User()->department_id)
                                    ->orderBy('meetings.meeting_date','desc')
                                    ->get();
        }

        return view('meeting.view',$result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { 
        $dep_id = Auth::User()->department_id;
        
        if(Auth::User()->hasAnyRole(['head','dean'])){
            $result = ["heads" => array(), "staffs" => array(), "display" => ""];
            if(Auth::User()->hasRole('dean')){
                $sch_id = DB::table('department_school')->select('school_id')->where('department_id',$dep_id)->get();

                $result['heads'] = DB::table('users')->join('role_user','users.id','=','role_user.user_id')
                                        ->join('roles','role_user.role_id','=','roles.id')
                                        ->join('departments','users.department_id','=','departments.id')
                                        ->join('department_school','departments.id','=','department_school.department_id')
                                        ->select('role_user.user_id','users.first_name','users.last_name')
                                        ->where('roles.role_name','head')
                                        ->where(function($query) use($sch_id){
                                            $query->where('department_school.school_id',$sch_id[0]->school_id);
                                        })->get();
            }
            if (Auth::User()->hasRole('head')) {
                $result['staffs'] = DB::table('users')
                                ->select('users.first_name','users.last_name','users.id as user_id')
                                ->where('users.department_id',$dep_id)->get();
            }
            if(Auth::User()->hasBothRoles('head','dean')){
                $result['display'] = "d-none";
            }
            return view('meeting.create',$result);
        }
        return redirect('/home');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $meeting = $request->all();
        DB::transaction(function() use($meeting){
            $type = "";
            if(Auth::User()->hasRole("head")){
                $type = "department";
            }elseif (Auth::User()->hasRole("dean")) {
                $type = "school";
            }elseif(Auth::User()->hasRole("director")){
                $type = "directorate";
            }

            $meeting_id = DB::table('meetings')
                        ->insertGetId(
                            array(
                                "meeting_title" => $meeting['title'],
                                "meeting_description" => $meeting['description'],
                                "meeting_type" => $type,
                                "meeting_date" => $meeting['date'],
                                "user_id" => Auth::User()->id
                            )
                    );

            if(Auth::User()->hasBothRoles('head','dean')){
                if($meeting['chairman'] == 1){
                    $this->create_department_meeting($meeting_id,$meeting);
                }elseif ($meeting['chairman'] == 2) {
                    $this->create_school_meeting($meeting_id,$meeting);
                }
            }elseif(Auth::User()->hasRole('dean')){
                $this->create_school_meeting($meeting_id,$meeting);
            }elseif (Auth::User()->hasRole('head')) {
                $this->create_department_meeting($meeting_id,$meeting);
            }elseif(Auth::User()->hasRole('director')){
                $this->create_directorate_meeting($meeting_id,$meeting);
            }
        });
        
        return back()->with('output','success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Meeting  $meeting
     * @return \Illuminate\Http\Response
     */
    public function show(Meeting $meeting)
    {
        $members = array();
        $documents = array();

        if($meeting->ofDepartment()){
            $members = Auth::User()->department->users;
            $documents = $meeting->departmentMeetings()->where('meeting_id',$meeting->id)->first()->documents;
        }elseif ($meeting->ofSchool()) {
            $schoolmeeting = $meeting->schoolMeetings()->where('school_id',Auth::User()->department()->school->id)->get();
            return redirect()->route('show_school_meeting'.'/'.$schoolmeeting->id);
        }
        $chair = $meeting->getChairman();
        $secr = $meeting->getSecretary();

        return view('meeting.show',["meeting" => $meeting, "members" => $members, "documents" => $documents,
         'chair' => $chair, 'secr' => $secr ] );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Meeting  $meeting
     * @return \Illuminate\Http\Response
     */
    public function edit(Meeting $meeting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Meeting $meeting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Meeting $meeting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Meeting  $meeting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Meeting $meeting)
    {
        //
    }

    public function uploadFile(Request $request, Meeting $meeting)
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
                    # code...
                }elseif ($meeting->ofSchool()) {
                    # code...
                }elseif ($meeting->ofCommittee()) {
                    # code...
                }
            }
        }

        return redirect()->route('view_meetings');
    }

    public function downloadFile(Request $request)
    {
        $document = $request->input('document');
        response()->download(storage_path($document["document_url"]),$document["document_type"]);
        echo json_encode($document);
    }
    public function createAttendence(Request $request, Meeting $meeting){
        $data = $request->input('data');
        DB::transaction(function() use($data,$meeting){
            $depMeeting = DepartmentMeeting::where('meeting_id',$meeting->id)
                            ->where(function($query){
                                    $query->where('department_id',Auth::User()->department_id);
                            })->get();
            
            foreach ($data as $status => $users) {
                foreach ($users as $user) {
                    $depMeeting->first()->attendences()->updateOrCreate(
                        ["user_id" => $user],
                        ["user_id" => $user,"status" => $status]
                    );
                }
            }
        });

        echo json_encode("success");
    }

    public function changeSecretary(Request $request, Meeting $meeting)
    {
        $secretary_id = $request->input('secretary_id');
        $depMeeting = $meeting->departmentMeetings()->where('department_id',Auth::User()->department_id);
        $depMeeting->update(['secretary_id' => $secretary_id]);

        echo json_encode($meeting);
    }

    protected function create_department_meeting($meeting_id,$meeting)
    {
        return DB::table('department_meeting')->insertGetId(
            array(
                "meeting_id" => $meeting_id,
                "department_id" => Auth::User()->department_id,
                "secretary_id" => $meeting['secretary'],
                "meeting_time" => $meeting['time'],
            )
        );
    }

    protected function create_school_meeting($meeting_id,$meeting)
    {
        return DB::table('school_meeting')->insertGetId(
            array(
                "meeting_id" => $meeting_id,
                "school_id" => Auth::User()->department->school[0]->id,
                "secretary_id" => $meeting['secretary'],
                "meeting_time" => $meeting['time'],
            )
        );
    }
    protected function create_directorate_meeting($meeting_id,$meeting)
    {
        return DB::table('directorate_meeting')->insertGetId(
            array(
                "meeting_id" => $meeting_id,
                "directorate_id" => Auth::User()->department()->directorate[0]->id,
                "secretary_id" => $meeting['secretary'],
                "meeting_time" => $meeting['time'],
            )
        );
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
