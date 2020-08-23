<?php

namespace App\Http\Controllers;

use Auth;
use DB;
Use App\User;
use App\School;
use App\Meeting;
use App\DepartmentMeeting;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

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

        if(Auth::User()->hasRoleType('head')){
            if(Auth::User()->department->belongsToSchool()){
                $sch_id = School::whereHas('departments',function(Builder $query){
                        $query->where('id','=',Auth::User()->department_id);
                    })->first()->id;
    
                $school_directorate = DB::table('meetings')->join('school_meetings','meetings.id','=','school_meetings.meeting_id')
                        ->where('school_meetings.school_id','=',$sch_id)
                        ->orderBy('meetings.meeting_date','desc');

            }elseif (Auth::User()->department->belongsToDirectorate()) {
                $dir_id = Directorate::whereHas('departments',function(Builder $query){
                        $query->where('id','=',Auth::User()->department_id);
                    })->first()->id;
    
                $school_directorate = DB::table('meetings')->join('directorate_meetings','meetings.id','=','directorate_meetings.meeting_id')
                        ->where('directorate_meetings.school_id','=',$dir_id)
                        ->orderBy('meetings.meeting_date','desc');
            }
        }
        $department = DB::table('meetings')->join('department_meeting','meetings.id','=','department_meeting.meeting_id')
                        ->where('department_meeting.department_id','=',Auth::User()->department_id)
                        ->orderBy('meetings.meeting_date','desc');
        $com = false;
        if(Auth::User()->isCommitteeMember()){
            $committees = Auth::User()->getCommittees();
            
            $committee = DB::table('meetings')->join('committee_meeting','meetings.id','=','committee_meeting.meeting_id')
                        ->select('meetings.*','committee_meeting.id','committee_meeting.meeting_id','committee_meeting.committee_id',
                        'committee_meeting.secretary_id','committee_meeting.meeting_time','committee_meeting.created_at','committee_meeting.updated_at')
                        ->whereIn('committee_meeting.committee_id',$committees->pluck("id"))
                        ->orderBy('meetings.meeting_date','desc');
            $com = true;
        }
        
        if(!$com){
            $resources["meetings"] = $school_directorate->union($department)->get();
        }else{
            $resources["meetings"] = $school_directorate->union($department)->union($committee)->get();
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
        $members = Array();

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

        return view('meeting.show',["specificMeeting" => $departmentMeeting, 
        "documents" => $departmentMeeting->documents,
        "chair" => $chair, "secr" => $secretary, "members" => $members, "resources" => [
            "urls" => ["change_secretary" => "change_department_meeting_secretary/",
            "invitation_link" => url('store_department_meeting_invitations/'.$departmentMeeting->id)
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
        $dep = false; $sch_dir = false; $com = false; $count = 0;

        if(Auth::User()->hasRoleType('head') && (($unit === "school") || ($unit === "directorate") || ($unit === "all"))){
            if(Auth::User()->department->belongsToSchool()){
                $sch_id = School::whereHas('departments',function(Builder $query){
                        $query->where('id','=',Auth::User()->department_id);
                    })->first()->id;
    
                $school_directorate = DB::table('meetings')->join('school_meetings','meetings.id','=','school_meetings.meeting_id')
                        ->where('school_meetings.school_id','=',$sch_id);

            }elseif (Auth::User()->department->belongsToDirectorate()) {
                $dir_id = Directorate::whereHas('departments',function(Builder $query){
                        $query->where('id','=',Auth::User()->department_id);
                    })->first()->id;
    
                $school_directorate = DB::table('meetings')->join('directorate_meetings','meetings.id','=','directorate_meetings.meeting_id')
                        ->where('directorate_meetings.directorate_id','=',$dir_id);
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
            $sch_dir = true;
        }
        if(($unit === "department") || ($unit === "all")){
            $department = DB::table('meetings')->join('department_meeting','meetings.id','=','department_meeting.meeting_id')
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

            $count += $department->count();
            $dep = true;
        }
        if(($unit === "committee") || ($unit === "all")){
            $committees = Auth::User()->getCommittees();
            
            $committee = DB::table('meetings')->join('committee_meeting','meetings.id','=','committee_meeting.meeting_id')
                        ->select('meetings.*','committee_meeting.id','committee_meeting.meeting_id','committee_meeting.committee_id',
                        'committee_meeting.secretary_id','committee_meeting.meeting_time','committee_meeting.created_at','committee_meeting.updated_at')
                        ->whereIn('committee_meeting.committee_id',$committees->pluck("id"))
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

            $count += $committee->count();
            $com = true;
        }

        if($dep && $sch_dir && $com){
            $resources["meetings"] = $department->union($school_directorate)->union($committee)->get();
        }elseif($dep && $sch_dir && !$com){
            $resources["meetings"] = $department->union($school_directorate)->get();
        }elseif($dep && !$sch_dir && $com){
            $resources["meetings"] = $department->union($committee)->get();
        }elseif(!$dep && $sch_dir && $com){
            $resources["meetings"] = $school_directorate->union($committee)->get();
        }elseif($dep && !$sch_dir && !$com){
            $resources["meetings"] = $department->get();
        }elseif(!$dep && $sch_dir && !$com){
            $resources["meetings"] = $school_directorate->get();
        }elseif(!$dep && !$sch_dir && $com){
            $resources["meetings"] = $committee->get();
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
