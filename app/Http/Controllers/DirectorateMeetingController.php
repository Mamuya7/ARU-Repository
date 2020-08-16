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
        $resources = ["school_directorate" => Array(), "department" => Array()];

        $directorate = new Directorate;

        if(Auth::User()->department->belongsToDirectorate()){
            $directorate = Directorate::whereHas('departments',function(Builder $query){
                    $query->where('id','=',Auth::User()->department_id);
                })->first();
        }elseif(Auth::User()->department->belongsToSchool()){
            $directorate = Directorate::withDirectorAs(Auth::User()->roles()->where('role_type','director')->first()->role_code);
        }

        $resources["school_directorate"] = DB::table('meetings')->join('directorate_meetings','meetings.id','=','directorate_meetings.meeting_id')
                            ->select('meetings.*','directorate_meetings.id as child_id','directorate_meetings.*')
                            ->where('directorate_meetings.directorate_id','=',$directorate->id)
                            ->orderBy('meetings.meeting_date','desc')->get();

        $resources["department"] = DB::table('meetings')->join('department_meeting','meetings.id','=','department_meeting.meeting_id')
                        ->where('department_meeting.department_id','=',Auth::User()->department_id)
                        ->orderBy('meetings.meeting_date','desc')->get();
                            
        return view('meeting.staff-view',$resources);
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
        DB::transaction(function()use($request){
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
        });

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
                }elseif($user->hasRoleType('administrative officer')){
                    $secr = $user;
                }
            }
        }
        
        if(Auth::User()->hasRoleType('director')){
            $data = array("profile" => Auth::User(), "attendence" => null);
            $chair = Auth::User();
            array_push($members,$data);
        }

        return view('meeting.show',["specificMeeting" => $directorateMeeting, 
        "documents" => $directorateMeeting->documents,
        "chair" => $chair, "secr" => $secr, "members" => $members,
        "resources" => [
            "urls" => ["change_secretary" => "change_directorate_meeting_secretary",
            "invitation_link" => url('store_directorate_meeting_invitations/'.$directorateMeeting->id)
            ]
        ]]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DirectorateMeeting  $directorateMeeting
     * @return \Illuminate\Http\Response
     */
    public function edit(DirectorateMeeting $directorateMeeting)
    {
        //
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
}
