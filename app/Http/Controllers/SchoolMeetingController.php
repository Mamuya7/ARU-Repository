<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use DB;
use App\Roles;
use App\Meeting;
use App\School;
use App\SchoolMeeting;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class SchoolMeetingController extends Controller
{  /**
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
        $resources = ["meetings" => Array(),
        "urls" => [
            "search_path" => url('search_school_meetings')
        ]];

        $sch_id = School::whereHas('departments',function(Builder $query){
                $query->where('id','=',Auth::User()->department_id);
            })->first()->id;

        $data = [];
        $department = DB::table('meetings')->join('department_meeting','meetings.id','=','department_meeting.meeting_id')
                            ->select('meetings.*','department_meeting.id as child_id','department_meeting.department_id as entity_id')
                            ->where('department_meeting.department_id','=',Auth::User()->department_id)
                            ->orderBy('meetings.meeting_date','desc');

        if($department->count() > 0){
            $data["data"] = $department->get();
            $data["url"] = url('show_department_meeting/');

            array_push($resources["meetings"],$data);
            $data = [];
        }

        $school = DB::table('meetings')->join('school_meetings','meetings.id','=','school_meetings.meeting_id')
                            ->select('meetings.*',"school_meetings.id as child_id","school_meetings.school_id as entity_id")
                            ->where('school_meetings.school_id','=',$sch_id)
                            ->orderBy('meetings.meeting_date','desc');
                            
        if($school->count() > 0){
            $data["data"] = $school->get();
            $data["url"] = url('show_school_meeting/');

            array_push($resources["meetings"],$data);
            $data = [];
        }

        if(Auth::User()->isCommitteeMember()){
            $committees = Auth::User()->getCommittees();
            
            $committee = DB::table('meetings')->join('committee_meetings','meetings.id','=','committee_meetings.meeting_id')
                        ->select('meetings.*','committee_meetings.id as child_id','committee_meetings.committee_id as entity_id')
                        ->whereIn('committee_meetings.committee_id',$committees->pluck("id"))
                        ->orderBy('meetings.meeting_date','desc');
        
            if($committee->count() > 0){
                $data["url"] = url('show_committee_meeting/');
                $data["data"] = $committee->get();
    
                array_push($resources["meetings"],$data);
                $data = [];
            }
        }
                            
        return view('meeting.staff-view',["resources" => $resources]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
            if(Auth::User()->hasRoleType('dean')){
                $result = ["heads" => array(), "staffs" => array(), "display" => "", "title" => "Create School Meeting"];

                $sch_id = School::whereHas('departments',function(Builder $query){
                    $query->where('id','=',Auth::User()->department_id);
                })->first()->id;

                $departments = School::find($sch_id)->departments;

                foreach($departments as $department){
                    foreach($department->users as $user){
                        if($user->hasRoleType('head')){
                            array_push($result['heads'],$user);
                        }
                    }
                }
                if(Auth::User()->hasBothRoleTypes('head','dean')){
                    $result['display'] = "d-none";
                }

                return view('meeting.staff-create',$result);
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
        $result = DB::transaction(function()use($request){
            $meeting = new Meeting;
            $meeting->meeting_title =  $request->input('title');
            $meeting->meeting_description = $request->input('description');
            $meeting->meeting_type = "school";
            $meeting->meeting_date = $request->input('date');
            $meeting->user_id = Auth::User()->id;

            $meeting->save();
            $school_id = School::whereHas('departments',function(Builder $query){
                            $query->where('id','=',Auth::User()->department_id);
                        })->first()->id;
    
            $schoolMeeting = SchoolMeeting::create([
                "meeting_id" => $meeting->id,
                "school_id" => $school_id,
                "secretary_id" => $request->input('secretary'),
                "meeting_time" => $request->input('time'),
            ]);

            return compact('schoolMeeting');
        });

        $members = $result['schoolMeeting']->boardMembers();
        $details = [
            'title'=>'mail from Ardhi university',
            'body'=>'This for notifying of meeting issues'
             ];
        
        \Mail::to($members)->send(new \App\Mail\MeetingCreated($details));

        return redirect('create_school_meeting')->with("output","School meeting created successfully!!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SchoolMeeting  $schoolMeeting
     * @return \Illuminate\Http\Response
     */
    public function show(SchoolMeeting $schoolMeeting)
    {
        $chair = null;
        $secr = null;
        $members = Array(); $invitations = Array();
        $invitees = $schoolMeeting->invitations;
        $attendence = $schoolMeeting->attendences;
        $school_departments = School::find($schoolMeeting->school_id)->departments;

        foreach ($school_departments as $department) {
            foreach ($department->users as $user) {
                $data = array("profile" => $user, "attendence" => null);

                if(sizeof($attendence) > 0){
                    foreach ($attendence as $value) {
                        if($value->user_id == $user->id){
                            $data["attendence"] = $value->status;
                            break;
                        }
                    }
                }

                if($user->hasRoleType('head')){
                    array_push($members,$data);
                }elseif($user->hasRoleType('dean')){
                    $chair = $user;
                    array_push($members,$data);
                }elseif($user->hasRoleType('administrative')){
                    $secr = $user;
                    array_push($members,$data);
                }
            }
        }
        // dd($secr->isDirty());
        if(sizeof($invitees) > 0){
            foreach ($invitees as $value) {
                $data = array(
                    "profile" => User::find($value->user_id), 
                    "role" => Roles::find($value->role_id), 
                    "invitation" => $value
                );
                
                array_push($invitations,$data);
            }
        }
        
        return view('meeting.show',[ 
            "resources" => [
                "chairman" => $chair,  
                "secretary" => $secr,
                "members" => $members,
                "documents" => $schoolMeeting->documents,
                "specificMeeting" => $schoolMeeting,
                "invites" => $invitations,
                "urls" => [
                    "change_secretary" => "change_school_meeting_secretary",
                    "set_attendence" => url("set_school_meeting_attendence/".$schoolMeeting->id),
                    // "update_attendence" => json_encode(url("update_school_meeting_attendence/".$schoolMeeting->id)),
                    "submit_attendence" => json_encode(url("submit_school_meeting_attendence/".$schoolMeeting->id)),
                    "invitation_link" => json_encode(url('store_school_meeting_invitations/'.$schoolMeeting->id)),
                    "remove_invitation" => url('delete_invitation\/')
                ]
            ]
        ]);
    }

    /**
     * Show the form for searching the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $resources = ["meetings" => Array(),
        "urls" => [
            "search_path" => url('search_school_meetings')
        ]];
        
        $text = '%' . $request->input('search') . '%';
        $unit = $request->input('unit-filter');
        $time = $request->input('time-filter');
        $count = 0;

        if(($unit === "all") || ($unit === "school")){
            $sch_id = School::whereHas('departments',function(Builder $query){
                    $query->where('id','=',Auth::User()->department_id);
                })->first()->id;

            $school = DB::table('meetings')->join('school_meetings','meetings.id','=','school_meetings.meeting_id')
                    ->select('meetings.*',"school_meetings.id as child_id","school_meetings.school_id as entity_id")
                    ->where('school_meetings.school_id','=',$sch_id);

            if($time === "past"){
                $school = $school->whereDate("meetings.meeting_date","<",date('Y-m-d'));
            }elseif($time === "coming"){
                $school = $school->whereDate("meetings.meeting_date",">=",date('Y-m-d'));
            }elseif($time === "today"){
                $school = $school->whereDate("meetings.meeting_date","=",date('Y-m-d'));
            }

            $school = $school->where(function($query) use($text){
                $query->where('meetings.meeting_title','like',$text)
                        ->orWhere('meetings.meeting_description','like',$text);
            })->orderBy('meetings.meeting_date','desc');
                            
            if($school->count() > 0){
                $count += $school->count();
                $data["data"] = $school->get();
                $data["url"] = url('show_school_meeting/');
    
                array_push($resources["meetings"],$data);
                $data = [];
            }
        }

        if(($unit === "department") || ($unit === "all")){
            $department = DB::table('meetings')->join('department_meeting','meetings.id','=','department_meeting.meeting_id')
                        ->select('meetings.*','department_meeting.id as child_id','department_meeting.department_id as entity_id')
                        ->where('department_meeting.department_id','=',Auth::User()->department_id);
            
            if($time === "past"){
                $department = $department->whereDate("meetings.meeting_date","<",date('Y-m-d'));
            }elseif($time === "coming"){
                $department = $department->whereDate("meetings.meeting_date",">=",date('Y-m-d'));
            }elseif($time === "today"){
                $department = $department->whereDate("meetings.meeting_date","=",date('Y-m-d'));
            }

            $department = $department->where(function($query) use($text){
                $query->where('meetings.meeting_title','like',$text)
                        ->orWhere('meetings.meeting_description','like',$text);
            })->orderBy('meetings.meeting_date','desc');

            if($department->count() > 0){
                $count += $department->count();
                $data["data"] = $department->get();
                $data["url"] = url('show_department_meeting/');
    
                array_push($resources["meetings"],$data);
                $data = [];
            }
        }

        if(($unit === "committee") || ($unit === "all")){
            $committees = Auth::User()->getCommittees();
            
            $committee = DB::table('meetings')->join('committee_meetings','meetings.id','=','committee_meetings.meeting_id')
                        ->select('meetings.*','committee_meetings.id as child_id','committee_meetings.committee_id as entity_id')
                        ->whereIn('committee_meetings.committee_id',$committees->pluck("id"))
                        ->orderBy('meetings.meeting_date','desc');
            
            if($time === "past"){
                $committee = $committee->whereDate("meetings.meeting_date","<",date('Y-m-d'));
            }elseif($time === "coming"){
                $committee = $committee->whereDate("meetings.meeting_date",">=",date('Y-m-d'));
            }elseif($time === "today"){
                $committee = $committee->whereDate("meetings.meeting_date","=",date('Y-m-d'));
            }

            $committee = $committee->where(function($query) use($text){
                $query->where('meetings.meeting_title','like',$text)
                        ->orWhere('meetings.meeting_description','like',$text);
            })->orderBy('meetings.meeting_date','desc');
        
            if($committee->count() > 0){
                $count += $committee->count();
                $data["url"] = url('show_committee_meeting/');
                $data["data"] = $committee->get();
    
                array_push($resources["meetings"],$data);
                $data = [];
            }
        }

        if($count === 0){
            session(["noresult" => "No Results Found!!"]);
        }else{
            $request->session()->forget('noresult');
        }
        
        $request->flash();

        return view('meeting.staff-view',["resources" => $resources]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SchoolMeeting  $schoolMeeting
     * @return \Illuminate\Http\Response
     */
    public function invite(Request $request, SchoolMeeting $schoolMeeting)
    {
        $data = $request->input('data');
        DB::transaction(function() use($data,$schoolMeeting){
            foreach ($data as $value) {
                $schoolMeeting->invitations()->updateOrCreate(
                    ["user_id" => $value['user_id']],
                    ["user_id" => $value['user_id'], "role_id" => $value['role_id']]
                );
            }
        });

        echo json_encode($schoolMeeting);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SchoolMeeting  $schoolMeeting
     * @return \Illuminate\Http\Response
     */
    public function destroy(SchoolMeeting $schoolMeeting)
    {
        //
    }

    public function submitAttendence(Request $request, SchoolMeeting $schoolMeeting){
        $data = $request->input('data');

        DB::transaction(function() use($data,$schoolMeeting){
            foreach ($data as $status => $users) {
                foreach ($users as $user) {
                    DB::table('attendences')
                    ->updateOrInsert(
                        ["user_id" => intVal($user), "attendenceable_id" => $schoolMeeting->id, "attendenceable_type" => 'App\SchoolMeeting'],
                        ["user_id" => intVal($user),"status" => $status]
                    );
                }
            }
        });

        echo json_encode($data);
    }

    public function setAttendence(Request $request, SchoolMeeting $schoolMeeting){
        $data = $request->except(['_token']);
// dd($data);
        DB::transaction(function() use($data,$schoolMeeting){
            foreach ($data as $user_id => $status) {
                DB::table('attendences')
                ->updateOrInsert(
                    ["user_id" => intVal($user_id), "attendenceable_id" => $schoolMeeting->id, "attendenceable_type" => 'App\SchoolMeeting'],
                    ["user_id" => intVal($user_id),"status" => $status]
                );
            }
        });
        
        return back();
    }

}
