<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Meeting;
use App\DepartmentSchool;
use App\Department;
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
        // $members = DB::table('users')
        //                 ->join('role_user','users.id','=','role_user.user_id')
        //                 ->join('roles','role_user.role_id','=','roles.id')
        //                 ->join('meeting_members','role_user.id','=','meeting_members.member_role_id')
        //                 ->select('users.first_name','users.last_name','roles.role_name','role_user.user_id', 'meeting_members.position')
        //                 ->where('meeting_members.meeting_id',$meetings->id)
        //                 ->get();
        // $creator = DB::table('users')
        //                 ->select('users.first_name','users.last_name')
        //                 ->where('users.id',$meetings->user_id)
        //                 ->get();

       
        if($meeting->ofDepartment()){
            $members = Auth::User()->department->users;
        }elseif ($meeting->ofSchool()) {
            $school = Auth::User()->department->school;
            $members = $school->schoolHeads();
        }
        $meeting->setMembers($members);
        $chair = $meeting->getChairman();
        $secr = $meeting->getSecretary();

        return view('meeting.show',["meeting" => $meeting, "members" => $members,
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

    public function fetch()
    {
        $dep_id = Auth::User()->department_id;
        $sch_id = DB::table('department_school')->select('school_id')->where('department_id',$dep_id)->get();

        $schools = DB::table('users')->join('role_user','users.id','=','role_user.user_id')
                                ->join('roles','role_user.role_id','=','roles.id')
                                ->join('departments','users.department_id','=','departments.id')
                                ->join('department_school','departments.id','=','department_school.department_id')
                                ->select('role_user.user_id','users.first_name','users.last_name')
                                ->where('roles.role_name','head')
                                ->where(function($query) use($sch_id){
                                    $query->where('department_school.school_id',$sch_id[0]->school_id);
                                })->get();
        $departments = DB::table('users')->where('users.department_id',$dep_id)->get();

        echo json_encode(["school_members" => $schools, "department_members" => $departments]);
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
}
