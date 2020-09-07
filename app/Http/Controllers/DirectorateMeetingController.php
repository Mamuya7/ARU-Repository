<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use App\User;
use App\Meeting;
use App\Directorate;
use App\DirectorateMeeting;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class DirectorateMeetingController extends Controller
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
            "search_path" => url('search_directorate_meetings')
        ]];

        $dir = new Directorate;
        
        $data = [];

        if(Auth::User()->department->belongsToDirectorate()){
            $dir = Directorate::whereHas('departments',function(Builder $query){
                    $query->where('id','=',Auth::User()->department_id);
                })->first();
        }elseif(Auth::User()->department->belongsToSchool()){
            $dir = Directorate::withDirectorAs(Auth::User()->roles()->where('role_type','director')->first()->role_code);
        }

        $directorate = DB::table('meetings')->join('directorate_meetings','meetings.id','=','directorate_meetings.meeting_id')
                        ->select('meetings.*',"directorate_meetings.id as child_id","directorate_meetings.directorate_id as entity_id")
                        ->where('directorate_meetings.directorate_id','=',$dir->id)
                        ->orderBy('meetings.meeting_date','desc');

        if($directorate->count() > 0){
            $data["url"] = url('show_directorate_meeting/');
            $data["data"] = $directorate->get();

            array_push($resources["meetings"],$data);
            $data = [];
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
        $result = ["heads" => array(), "staffs" => array(), "display" => "", "title" => "Create Directorate Meeting"];

        if(Auth::User()->hasRoleType('director')){

            $directorate = Directorate::withDirectorAs(Auth::User()->roles()->where('role_type','director')->first()->role_code);
            
            $departments = $directorate->departments;
    
            foreach($departments as $department){
                foreach($department->users as $user){
                    if($user->hasRoleType('head')){
                        array_push($result['heads'],$user);
                    }
                }
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
            $meeting->meeting_type = "directorate";
            $meeting->meeting_date = $request->input('date');
            $meeting->user_id = Auth::User()->id;

            $meeting->save();
            $directorate = Directorate::withDirectorAs(Auth::User()->roles()->where('role_type','director')->first()->role_code);
    
            $directorateMeeting = new DirectorateMeeting;
            $directorateMeeting->meeting_id = $meeting->id;
            $directorateMeeting->directorate_id = $directorate->id;
            $directorateMeeting->secretary_id = $request->input('secretary');
            $directorateMeeting->meeting_time = $request->input('time');

            $directorateMeeting->save();

            return compact('directorateMeeting');
        });

        $members = $result['directorateMeeting']->boardMembers();
        $details = [
            'title'=>'mail from Ardhi university',
            'body'=>'This for notifying of meeting issues'
            ]; 
        
        \Mail::to($members)->send(new \App\Mail\MeetingCreated($details));

        return redirect('create_directorate_meeting')->with("output","Directorate meeting created successfully!!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DirectorateMeeting  $directorateMeeting
     * @return \Illuminate\Http\Response
     */
    public function show(DirectorateMeeting $directorateMeeting)
    {
        $chair = new User;
        $secr = new User;
        $members = Array();
        $directorate_departments = Directorate::find($directorateMeeting->directorate_id)->departments;
        foreach ($directorate_departments as $department) {
            foreach ($department->users as $user) {
                $data = array("profile" => $user, "attendence" => null);
                if($user->hasRoleType('head')){
                    array_push($members,$data);
                }elseif($user->hasRoleType('director')){
                    $chair = $user;
                    array_push($members,$data);
                }elseif($user->id === $directorateMeeting->secretary_id){
                    $secr = $user;
                }
            }
        }
        
        if(Auth::User()->hasRoleType('director')){
            $data = array("profile" => Auth::User(), "attendence" => null);
            $chair = Auth::User();
            array_push($members,$data);
        }

        return view('meeting.show',[
            "resources" => [
                "chairman" => $chair, 
                "secretary" => $secr, 
                "members" => $members,
                "specificMeeting" => $directorateMeeting, 
                "documents" => $directorateMeeting->documents,
                "invites" => $invitations,
                "urls" => [
                    "change_secretary" => url("change_directorate_meeting_secretary".$directorateMeeting->id),
                    "set_attendence" => json_encode(url("set_directorate_meeting_attendence/".$directorateMeeting->id)),
                    "update_attendence" => json_encode(url("update_directorate_meeting_attendence/".$directorateMeeting->id)),
                    "invitation_link" => url('store_directorate_meeting_invitations/'.$directorateMeeting->id),
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
            "search_path" => url('search_directorate_meetings')
        ]];
        
        $text = '%' . $request->input('search') . '%';
        $unit = $request->input('unit-filter');
        $time = $request->input('time-filter');
        $count = 0;

        if(($unit === "all") || ($unit === "directorate")){
            if(Auth::User()->department->belongsToDirectorate()){
                $dir_id = Directorate::whereHas('departments',function(Builder $query){
                        $query->where('id','=',Auth::User()->department_id);
                    })->first()->id;
            }elseif(Auth::User()->department->belongsToSchool()){
                $dir_id = Directorate::withDirectorAs(Auth::User()->roles()->where('role_type','director')->first()->role_code)->id;
            }

            $directorate = DB::table('meetings')->join('directorate_meetings','meetings.id','=','directorate_meetings.meeting_id')
                    ->select('meetings.*',"directorate_meetings.id as child_id","directorate_meetings.directorate_id as entity_id")
                    ->where('directorate_meetings.directorate_id','=',$dir_id);

            if($time === "past"){
                $directorate = $directorate->whereDate("meetings.meeting_date","<",date('Y-m-d'));
            }elseif($time === "coming"){
                $directorate = $directorate->whereDate("meetings.meeting_date",">=",date('Y-m-d'));
            }elseif($time === "today"){
                $directorate = $directorate->whereDate("meetings.meeting_date","=",date('Y-m-d'));
            }

            $directorate = $directorate->where(function($query) use($text){
                $query->where('meetings.meeting_title','like',$text)
                        ->orWhere('meetings.meeting_description','like',$text);
            })->orderBy('meetings.meeting_date','desc');

            if($directorate->count() > 0){
                $count += $directorate->count();
                $data["url"] = url('show_directorate_meeting/');
                $data["data"] = $directorate->get();
    
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
            
            $committee = DB::table('meetings')->join('committee_meetingss','meetings.id','=','committee_meetings.meeting_id')
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
     * @param  \App\DirectorateMeeting  $directorateMeeting
     * @return \Illuminate\Http\Response
     */
    public function invite(Request $request, DirectorateMeeting $directorateMeeting)
    {
        $data = $request->input('data');
        DB::transaction(function() use($data,$directorateMeeting){
            foreach ($data as $value) {
                $directorateMeeting->invitations()->updateOrCreate(
                    ["user_id" => $value['user_id']],
                    ["user_id" => $value['user_id'], "role_id" => $value['role_id']]
                );
            }
        });

        echo json_encode($directorateMeeting);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DirectorateMeeting  $directorateMeeting
     * @return \Illuminate\Http\Response
     */
    public function destroy(DirectorateMeeting $directorateMeeting)
    {
        //
    }

    public function updateAttendence(Request $request, DirectorateMeeting $directorateMeeting){
        $data = $request->input('data');
        DB::transaction(function() use($data,$directorateMeeting){
            
            DB::table('attendences')
            ->updateOrInsert(
                ["user_id" => intVal($data['user_id']), "attendenceable_id" => $directorateMeeting->id, "attendenceable_type" => 'App\DirectorateMeeting'],
                ["user_id" => intVal($data['user_id']),"status" => $data['status']]
            );
        });
        
        echo json_encode($data);
    }

    public function setAttendence(Request $request, DirectorateMeeting $directorateMeeting){
        $data = $request->input('data');

        DB::transaction(function() use($data,$directorateMeeting){
            foreach ($data as $status => $users) {
                foreach ($users as $user) {
                    DB::table('attendences')
                    ->updateOrInsert(
                        ["user_id" => intVal($user), "attendenceable_id" => $directorateMeeting->id, "attendenceable_type" => 'App\DirectorateMeeting'],
                        ["user_id" => intVal($user),"status" => $status]
                    );
                }
            }
        });

        echo json_encode($data);
    }
}
