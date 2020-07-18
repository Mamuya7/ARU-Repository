<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Meetings;
use App\DepartmentSchool;
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
                                ->where('school_meeting.school_id',Auth::User()->department()->departmentSchool()->getSchoolId())
                                ->orderBy('meetings.meeting_date','desc')
                                ->get();
        }
        if(Auth::User()->hasAnyRole(['head','staff'])){
            $result['department'] = DB::table('meetings')
                                    ->join('department_meeting','meeting_id','=','department_meeting.meeting_id')
                                    ->where('department_meeting.department_id',Auth::User()->department_id)
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
            $meeting_id = DB::table('meetings')
                        ->insertGetId(
                            array(
                                "meeting_title" => $meeting['title'],
                                "meeting_description" => $meeting['description'],
                                "meeting_date" => $meeting['date'],
                                "meeting_time" => $meeting['time'],
                                "user_id" => Auth::User()->id
                            )
                    );

            if(Auth::User()->hasBothRoles('head','dean')){
                if($meeting['chairman'] == 1){
                    $this->set_department_meeting($meeting_id,$meeting['secretary'],Auth::User()->department_id);
                }elseif ($meeting['chairman'] == 2) {
                    $this->set_school_meeting($meeting_id,$meeting['secretary'],
                    DepartmentSchool::getDepartmentSchoolId(Auth::User()->department_id));
                }
            }elseif(Auth::User()->hasRole('dean')){
                $this->set_school_meeting($meeting_id,$meeting['secretary'],
                DepartmentSchool::getDepartmentSchoolId(Auth::User()->department_id));
            }elseif (Auth::User()->hasRole('head')) {
                $this->set_department_meeting($meeting_id,$meeting['secretary'],Auth::User()->department_id);
            }
        });
        
        return back()->with('output','success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Meetings  $meetings
     * @return \Illuminate\Http\Response
     */
    public function show(Meetings $meetings)
    {
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

        // $meetings->setMembers($members);
        // $chair = $meetings->getChairman();
        // $secr = $meetings->getSecretary();
        // $chairman = ($chair === null)? 'Not Selected': $chair->last_name.' '.$chair->first_name;
        // $secretary = ($secr === null)? 'Not Selected': $secr->last_name.' '.$secr->first_name;

        return view('meeting.show'/**,["meeting" => $meetings, "members" => $members, "creator" => $creator[0],
         'chairman' => $chairman, 'secretary' => $secretary] */);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Meetings  $meetings
     * @return \Illuminate\Http\Response
     */
    public function edit(Meetings $meetings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Meetings  $meetings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Meetings $meetings)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Meetings  $meetings
     * @return \Illuminate\Http\Response
     */
    public function destroy(Meetings $meetings)
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

    protected function set_department_meeting($meeting,$secretary,$department)
    {
        return DB::table('department_meeting')->insertGetId(
            array(
                "meeting_id" => $meeting,
                "department_id" => $department,
                "secretary_id" => $secretary
            )
        );
    }

    protected function set_school_meeting($meeting,$secretary,$school)
    {
        return DB::table('school_meeting')->insertGetId(
            array(
                "meeting_id" => $meeting,
                "school_id" => $school,
                "secretary_id" => $secretary
            )
        );
    }
}
