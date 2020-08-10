<?php

namespace App\Http\Controllers;

use Auth;
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
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
            $result = ["heads" => array(), "staffs" => array(), "display" => "", "title" => "Create School Meeting"];

            if(Auth::User()->hasRole('dean')){

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

                return view('meeting.create',$result);
            }
            if(Auth::User()->hasBothRoles('head','dean')){
                $result['display'] = "d-none";
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
            // $meeting = Meeting::create([
            //     "meeting_title" => $request->input('title'),
            //     "meeting_description" => $request->input('description'),
            //     "meeting_type" => "school",
            //     "meeting_date" => $request->input('date'),
            //     "user_id" => Auth::User()->id
            // ]);
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

        return redirect('create_school_meeting')->with("output","success");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SchoolMeeting  $schoolMeeting
     * @return \Illuminate\Http\Response
     */
    public function show(SchoolMeeting $schoolMeeting)
    {
        //
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
