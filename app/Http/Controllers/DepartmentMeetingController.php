<?php

namespace App\Http\Controllers;

use Auth;
use DB;
Use App\User;
use App\Roles;
use App\School;
use App\Meeting;
use App\Attendence;
use App\Directorate;
use App\DepartmentMeeting;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Mail;
class DepartmentMeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $resources = ["meetings" => Array(),
        "urls" => [
            "search_path" => url('search_department_meetings')
        ]];
        
        $data = [];

        if(Auth::User()->hasRoleType('head')){
            if(Auth::User()->department->belongsToSchool()){
                $sch_id = School::whereHas('departments',function(Builder $query){
                        $query->where('id','=',Auth::User()->department_id);
                    })->first()->id;
    
                $school_directorate = DB::table('meetings')->join('school_meetings','meetings.id','=','school_meetings.meeting_id')
                        ->select('meetings.*',"school_meetings.id as child_id","school_meetings.school_id as entity_id")
                        ->where('school_meetings.school_id','=',$sch_id)
                        ->orderBy('meetings.meeting_date','desc');
                $data["url"] = url('show_school_meeting/');

            }elseif (Auth::User()->department->belongsToDirectorate()) {
                $dir_id = Directorate::whereHas('departments',function(Builder $query){
                        $query->where('id','=',Auth::User()->department_id);
                    })->first()->id;
    
                $school_directorate = DB::table('meetings')->join('directorate_meetings','meetings.id','=','directorate_meetings.meeting_id')
                        ->select('meetings.*',"directorate_meetings.id as child_id","directorate_meetings.directorate_id as entity_id")
                        ->where('directorate_meetings.directorate_id','=',$dir_id)
                        ->orderBy('meetings.meeting_date','desc');
                $data["url"] = url('show_directorate_meeting/');
            }

            if($school_directorate->count() > 0){
                $data["data"] = $school_directorate->get();
                array_push($resources["meetings"],$data);
                $data = [];
            }
        }

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

        if(Auth::User()->hasRoleType('head')){
            $result = ["heads" => array(), "staffs" => array(), "display" => "", "title" => "Create Department Meeting"];

            foreach(Auth::User()->department->users as $user){
                array_push($result['staffs'],$user);
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
        DB::transaction(function()use($request){
            $meeting = new Meeting;
            $meeting->meeting_title =  $request->input('title');
            $meeting->meeting_description = $request->input('description');
            $meeting->meeting_type = "department";
            $meeting->meeting_date = $request->input('date');
            $meeting->user_id = Auth::User()->id;

            $meeting->save();

            DepartmentMeeting::create([
                "meeting_id" => $meeting->id,
                "department_id" => Auth::User()->department_id,
                "secretary_id" => $request->input('secretary'),
                "meeting_time" => $request->input('time'),
            ]);
        });

        $members = Auth::User()->department->users;


       // dd($members);
        $details = [
                'title'=>'mail from Ardhi university',
                'body'=>'This for notifying of meeting issues'
                 ];
            
               // $data = array('mankilla12345@gmail.com','kilango12345@gmail.com');
            
       \Mail::to($members)->send(new \App\Mail\MeetingCreated($details));
        

        return redirect('create_department_meeting')->with("output","Department meeting created successfully!!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DepartmentMeeting  $departmentMeeting
     * @return \Illuminate\Http\Response
     */
    public function show(DepartmentMeeting $departmentMeeting)
    {
        $users = Auth::User()->department->users;
        $chair = new User; $secretary = new User;
        $attendence = $departmentMeeting->attendences;
        $invitees = $departmentMeeting->invitations;
        $members = Array(); $invitations = Array();

        foreach ($users as $user) {
            if($user->hasRoleType('head')){
                $chair = $user;
            }

            if($user->id === $departmentMeeting->secretary_id){
                $secretary = $user;
            }

            $data = array("profile" => $user, "attendence" => null);

            if(sizeof($attendence) > 0){
                foreach ($attendence as $value) {
                    if($value->user_id == $user->id){
                        $data["attendence"] = $value->status;
                        break;
                    }
                }
            }

            array_push($members,$data);
        }
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
                "specificMeeting" => $departmentMeeting, 
                "documents" => $departmentMeeting->documents,
                "chairman" => $chair, 
                "secretary" => $secretary, 
                "members" => $members, 
                "invites" => $invitations,
                "urls" => [
                    "change_secretary" => url("change_department_meeting_secretary/".$departmentMeeting->id),
                    "set_attendence" => url("set_department_meeting_attendence/".$departmentMeeting->id),
                    // "update_attendence" => json_encode(url("update_department_meeting_attendence/".$departmentMeeting->id)),
                    "submit_attendence" => json_encode(url("submit_department_meeting_attendence/".$departmentMeeting->id)),
                    "invitation_link" => json_encode(url('store_department_meeting_invitations/'.$departmentMeeting->id)),
                    "remove_invitation" => url('delete_invitation\/')
                ]
        ]]);
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
            "search_path" => url('search_department_meetings')
        ]];
        
        $text = '%' . $request->input('search') . '%';
        $unit = $request->input('unit-filter');
        $time = $request->input('time-filter');
        $count = 0;

        if(Auth::User()->hasRoleType('head') && (($unit === "school") || ($unit === "directorate") || ($unit === "all"))){
            if(Auth::User()->department->belongsToSchool()){
                $sch_id = School::whereHas('departments',function(Builder $query){
                        $query->where('id','=',Auth::User()->department_id);
                    })->first()->id;
    
                $school_directorate = DB::table('meetings')->join('school_meetings','meetings.id','=','school_meetings.meeting_id')
                        ->select('meetings.*',"school_meetings.id as child_id","school_meetings.school_id as entity_id")
                        ->where('school_meetings.school_id','=',$sch_id);

                $data["url"] = url('show_school_meeting/');

            }elseif (Auth::User()->department->belongsToDirectorate()) {
                $dir_id = Directorate::whereHas('departments',function(Builder $query){
                        $query->where('id','=',Auth::User()->department_id);
                    })->first()->id;
    
                $school_directorate = DB::table('meetings')->join('directorate_meetings','meetings.id','=','directorate_meetings.meeting_id')
                        ->select('meetings.*',"directorate_meetings.id as child_id","directorate_meetings.directorate_id as entity_id")
                        ->where('directorate_meetings.directorate_id','=',$dir_id);

                $data["url"] = url('show_directorate_meeting/');
            }

            if($time === "past"){
                $school_directorate = $school_directorate->whereDate("meetings.meeting_date","<",date('Y-m-d'));
            }elseif($time === "coming"){
                $school_directorate = $school_directorate->whereDate("meetings.meeting_date",">=",date('Y-m-d'));
            }elseif($time === "today"){
                $school_directorate = $school_directorate->whereDate("meetings.meeting_date","=",date('Y-m-d'));
            }

            $school_directorate = $school_directorate->where(function($query) use($text){
                $query->where('meetings.meeting_title','like',$text)
                        ->orWhere('meetings.meeting_description','like',$text);
            });
            
            $count += $school_directorate->count();
            if($count > 0){
                $data["data"] = $school_directorate->get();
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
            });

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
     * @param  \App\DepartmentMeeting  $departmentMeeting
     * @return \Illuminate\Http\Response
     */
    public function invite(Request $request, DepartmentMeeting $departmentMeeting)
    {
        $data = $request->input('data');
        DB::transaction(function() use($data,$departmentMeeting){
            foreach ($data as $value) {
                $departmentMeeting->invitations()->updateOrCreate(
                    ["user_id" => $value['user_id']],
                    ["user_id" => $value['user_id'], "role_id" => $value['role_id']]
                );
            }
        });

        echo json_encode($departmentMeeting);
    }

    // public function updateAttendence(Request $request, DepartmentMeeting $departmentMeeting){
    //     $data = $request->input('data');
    //     DB::transaction(function() use($data,$departmentMeeting){
            
    //         DB::table('attendences')
    //         ->updateOrInsert(
    //             ["user_id" => intVal($data['user_id']), "attendenceable_id" => $departmentMeeting->id, "attendenceable_type" => 'App\DepartmentMeeting'],
    //             ["user_id" => intVal($data['user_id']),"status" => $data['status']]
    //         );
    //     });
        
    //     echo json_encode($data);
    // }

    public function setAttendence(Request $request, DepartmentMeeting $departmentMeeting){
        $data = $request->except(['_token']);
        // dd($data);
        DB::transaction(function() use($data,$departmentMeeting){
            foreach ($data as $user_id => $status) {
                DB::table('attendences')
                ->updateOrInsert(
                    ["user_id" => intVal($user_id), "attendenceable_id" => $departmentMeeting->id, "attendenceable_type" => 'App\DepartmentMeeting'],
                    ["user_id" => intVal($user_id),"status" => $status]
                );
            }
        });
        
        return back();
    }

    public function submitAttendence(Request $request, DepartmentMeeting $departmentMeeting){
        $data = $request->input('data');

        DB::transaction(function() use($data,$departmentMeeting){
            foreach ($data as $status => $users) {
                foreach ($users as $user) {
                    DB::table('attendences')
                    ->updateOrInsert(
                        ["user_id" => intVal($user), "attendenceable_id" => $departmentMeeting->id, "attendenceable_type" => 'App\DepartmentMeeting'],
                        ["user_id" => intVal($user),"status" => $status]
                    );
                }
            }
        });

        echo json_encode($data);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DepartmentMeeting  $departmentMeeting
     * @return \Illuminate\Http\Response
     */
    public function destroy(DepartmentMeeting $departmentMeeting)
    {
        //
    }

    public function changeSecretary(Request $request, DepartmentMeeting $departmentMeeting)
    {
        $secretary_id = $request->input('secretary');
        $departmentMeeting->update(["secretary_id" => $secretary_id]);
        return back()->with("response","Secretary Updated Successfully");
    }
}
