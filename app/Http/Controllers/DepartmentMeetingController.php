<?php

namespace App\Http\Controllers;

use Auth;
Use App\User;
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

        if(Auth::User()->department->belongsToSchool()){
            $sch_id = School::whereHas('departments',function(Builder $query){
                    $query->where('id','=',Auth::User()->department_id);
                })->first()->id;

            $meetings = DB::table('meetings')->join('school_meetings','meetings.id','=','school_meetings.meeting_id')
                    ->where('school_meetings.school_id','=',$sch_id)
                    ->orderBy('meetings.meeting_date','desc')->get();
        }elseif (Auth::User()->department->belongsToDirectorate()) {
            $dir_id = Directorate::whereHas('departments',function(Builder $query){
                    $query->where('id','=',Auth::User()->department_id);
                })->first()->id;

            $meetings = DB::table('meetings')->join('directorate_meetings','meetings.id','=','directorate_meetings.meeting_id')
                    ->where('directorate_meetings.school_id','=',$dir_id)
                    ->orderBy('meetings.meeting_date','desc')->get();
        }
        $department_meetings = DB::table('meetings')->join('department_meeting','meetings.id','=','department_meeting.meeting_id')
                        ->where('department_meeting.department_id','=',Auth::User()->department_id)
                        ->orderBy('meetings.meeting_date','desc')->get();         
        return view('meeting.staff-view',["school_directorate" => $meetings, "department" => $department_meetings]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        if(Auth::User()->hasRole('head')){
            $result = ["heads" => array(), "staffs" => array(), "display" => "", "title" => "Create Department Meeting"];

            // $sch_id = School::whereHas('departments',function(Builder $query){
            //     $query->where('id','=',Auth::User()->department_id);
            // })->first()->id;

            // $departments = School::find($sch_id)->departments;

            foreach(Auth::User()->department->users as $user){
                array_push($result['staffs'],$user);
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
        $chair = new User;
        foreach ($users as $user) {
            if($user->hasRole('head')){
                $chair = $user;
            }
        }

        return view('meeting.show',["specificMeeting" => $departmentMeeting, 
        "documents" => $departmentMeeting->documents,
        "chair" => $chair, "secr" => null, "members" => $users]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DepartmentMeeting  $departmentMeeting
     * @return \Illuminate\Http\Response
     */
    public function edit(DepartmentMeeting $departmentMeeting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DepartmentMeeting  $departmentMeeting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DepartmentMeeting $departmentMeeting)
    {
        //
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
}
