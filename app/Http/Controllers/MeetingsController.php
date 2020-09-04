<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use DateTime;
use App\User;
use App\Roles;
use App\Meeting;
use App\Committee;
use App\Document;
use App\DepartmentMeeting;
use App\SchoolMeeting;
use App\CommitteeMeeting;
use App\DirectorateMeeting;
use App\School;
use App\Department;
use App\Directorate;
use App\Attendence;
use Response;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

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
        if (Auth::User()->hasRoleType('system administrator')) {
            $result = [
                'school' => Meeting::all()->where('meeting_type','school')->get(), 
                'department' => Meeting::all()->where('meeting_type','department')->get(), 
                'directorate' => Meeting::all()->where('meeting_type','directorate')->get()
            ];
    
            return view('meeting.admin-view',$result);
        }else{
            return redirect()->route('viewDepartmentMeetings');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { 
        if (Auth::User()->hasRoleType('system administrator')) {
            $result = ["heads" => Array(), "staffs" => Array(), "display" => '', "title" => "Create Meeting"];
            
                return view('meeting.admin-create', $result);
        }else{
            return redirect('/home');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $date = new DateTime($request->input('date'));
        $today = new DateTime(date('Y-m-d'));

        if($date < $today){
            session([
                "output" => "Incorrect Date!!",
                "color" => "bg-danger"
            ]);
            $request->flash();
            return back();
        }

        DB::transaction(function() use($request){
            $type = $request->input('meeting_type');
            $meeting = new Meeting;
            $meeting->meeting_title =  $request->input('title');
            $meeting->meeting_description = $request->input('description');
            $meeting->meeting_type = (($type === "accademic") || ($type === "administrative"))? "department" : $type;
            $meeting->meeting_date = $request->input('date');
            $meeting->user_id = Auth::User()->id;

            $meeting->save();

            if(($type === "accademic") || ($type === "administrative")){
                $this->create_department_meetings($meeting, $request);
            }elseif($type === "school"){
                $this->create_school_meetings($meeting, $request);
            }elseif ($type === "directorate") {
                $this->create_directorate_meetings($meeting, $request);
            }elseif($type === "committee"){
                $this->create_committee_meetings($meeting, $request);
            }
        });
        
        session([
            "output" => "Meeting created successfully!!",
            "color" => "bg-success"
        ]);
        return back();
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
            $departmentMeeting = $meeting->departmentMeetings()->where('department_id',Auth::User()->department_id)->first();
            return redirect()->route('showDepartmentMeeting',[$departmentMeeting]);
        }elseif ($meeting->ofSchool()) {
            $schoolMeeting = $meeting->schoolMeetings()->where('school_id',Auth::User()->school()->id)->first();
            // return redirect('show_school_meeting/'.$schoolmeeting->id);
            return redirect()->route('showSchoolMeeting',[$schoolMeeting]);
        }elseif ($meeting->ofDirectorate()) {
            $directorate = new Directorate;

            if(Auth::User()->department->belongsToDirectorate()){
                $directorate = Directorate::whereHas('departments',function(Builder $query){
                        $query->where('id','=',Auth::User()->department_id);
                    })->first();
            }elseif(Auth::User()->department->belongsToSchool()){
                $directorate = Directorate::withDirectorAs(Auth::User()->roles()->where('role_type','director')->first()->role_code);
            }
            $directorateMeeting = $meeting->directorateMeetings()->where('directorate_id',$directorate->id)->first();
            return redirect()->route('showDirectorateMeeting',[$directorateMeeting]);
        }elseif ($meeting->ofCommittee()) {
            dd($meeting->committees);
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
        $data = $request->all();
        
        $meeting->update([
            "meeting_title" => $data['title'],
            "meeting_description" => $data['description'],
            "meeting_date" => $data['date']
        ]);

        return back()->with("response","Meeting details updated successfully");
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

        return back();
    }

    public function invitation()
    {
        $data = Array();
        foreach (User::all() as $user) {
            $data2 = Array("user" => $user, "roles" => $user->roles);
            array_push($data,$data2);
        }

        echo json_encode([
            "users" => $data,
            "departments" => Department::all(),
            "directorates" => Directorate::all(),
            "committees" => Committee::all(),
            "roletypes" => Roles::select(['role_type'])->distinct('role_type')->get()
        ]);
    }
    public function downloadFile(Request $request)
    {
        $document = $request->input('document');
        response()->download(storage_path('app\\'.$document["document_url"]),$document["document_type"]);
        echo json_encode(storage_path('app\\'.$document["document_url"]));
    }

    public function changeSecretary(Request $request, Meeting $meeting)
    {
        $secretary_id = $request->input('secretary_id');
        $depMeeting = $meeting->departmentMeetings()->where('department_id',Auth::User()->department_id);
        $depMeeting->update(['secretary_id' => $secretary_id]);

        echo json_encode($meeting);
    }

    protected function create_department_meetings(Meeting $meeting, Request $request)
    {
        $departments = $request->input('typeid');
        $time = $request->input('time');

        foreach ($departments as $department_id) {
            $meeting->departments()->attach($department_id,["meeting_time" => $time]);
        }
    }
    protected function create_school_meetings(Meeting $meeting, Request $request)
    {
        $schools = $request->input('typeid');
        $time = $request->input('time');

        foreach ($schools as $school_id) {
            $meeting->schools()->attach($school_id,["meeting_time" => $time]);
        }
    }
    protected function create_directorate_meetings(Meeting $meeting, Request $request)
    {
        $directorates = $request->input('typeid');
        $time = $request->input('time');

        foreach ($directorates as $directorate_id) {
            $meeting->directorates()->attach($directorate_id,["meeting_time" => $time]);
        }
    }

    protected function create_committee_meetings(Meeting $meeting, Request $request)
    {
        $committees = $request->input('typeid');
        $time = $request->input('time');

        foreach ($committees as $committee_id) {
            $meeting->committees()->attach($committee_id,["meeting_time" => $time]);
        }
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
