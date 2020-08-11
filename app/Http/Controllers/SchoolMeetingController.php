<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use DB;
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
        $sch_id = School::whereHas('departments',function(Builder $query){
                $query->where('id','=',Auth::User()->department_id);
            })->first()->id;

        $department_meetings = DB::table('meetings')->join('department_meeting','meetings.id','=','department_meeting.meeting_id')
                            ->select('meetings.*','department_meeting.id as child_id','department_meeting.*')
                            ->where('department_meeting.department_id','=',Auth::User()->department_id)
                            ->orderBy('meetings.meeting_date','desc')->get();
        $school_meetings = DB::table('meetings')->join('school_meetings','meetings.id','=','school_meetings.meeting_id')
                            ->select('meetings.*','school_meetings.id as child_id','school_meetings.*')
                            ->where('school_meetings.school_id','=',$sch_id)
                            ->orderBy('meetings.meeting_date','desc')->get();         
        return view('meeting.staff-view',["school_directorate" => $school_meetings, "department" => $department_meetings]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
            if(Auth::User()->hasRole('dean')){
                $result = ["heads" => array(), "staffs" => array(), "display" => "", "title" => "Create School Meeting"];

                $sch_id = School::whereHas('departments',function(Builder $query){
                    $query->where('id','=',Auth::User()->department_id);
                })->first()->id;

                $departments = School::find($sch_id)->departments;

                foreach($departments as $department){
                    foreach($department->users as $user){
                        if($user->hasRole('head')){
                            array_push($result['heads'],$user);
                        }
                    }
                }
                if(Auth::User()->hasBothRoles('head','dean')){
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
            $meeting->meeting_type = "school";
            $meeting->meeting_date = $request->input('date');
            $meeting->user_id = Auth::User()->id;

            $meeting->save();
            $school_id = School::whereHas('departments',function(Builder $query){
                            $query->where('id','=',Auth::User()->department_id);
                        })->first()->id;
    
            SchoolMeeting::create([
                "meeting_id" => $meeting->id,
                "school_id" => $school_id,
                "secretary_id" => $request->input('secretary'),
                "meeting_time" => $request->input('time'),
            ]);
        });

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
        $chair = new User;
        $secr = new User;
        $members = Array();
        $school_departments = School::find($schoolMeeting->school_id)->departments;
        foreach ($school_departments as $department) {
            foreach ($department->users as $user) {
                if($user->hasRole('head')){
                    array_push($members,$user);
                }elseif($user->hasRole('dean')){
                    $chair = $user;
                    array_push($members,$user);
                }elseif($user->hasRole('administrative officer')){
                    $secr = $user;
                }
            }
        }
        return view('meeting.show',["specificMeeting" => $schoolMeeting, 
        "documents" => $schoolMeeting->documents,
        "chair" => $chair, "secr" => $secr, "members" => $members]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SchoolMeeting  $schoolMeeting
     * @return \Illuminate\Http\Response
     */
    public function edit(SchoolMeeting $schoolMeeting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SchoolMeeting  $schoolMeeting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SchoolMeeting $schoolMeeting)
    {
        //
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
}
