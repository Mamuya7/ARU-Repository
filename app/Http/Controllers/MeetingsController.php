<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Meetings;
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
        $meetings = DB::table('meetings')
                        ->join('meeting_members','meetings.id','=','meeting_members.meeting_id')
                        ->join('user_roles','meeting_members.member_role_id','=','user_roles.id')
                        ->join('roles','user_roles.role_id','=','roles.id')
                        ->select('meetings.id as meeting_id','meetings.meeting_title','meetings.meeting_description')
                        ->where('user_roles.user_id','=',Auth::User()->id)
                        ->get();

        return view('meeting.view',['meetings' => $meetings]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = DB::table('roles')->get();

        return view('meeting.create',['roles' => $roles]);
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
                                "meeting_title" => $meeting['agenda'],
                                "meeting_description" => $meeting['description'],
                                "user_id" => Auth::User()->id
                            )
                    );

            DB::table('meeting_boards')->insertGetId(
                array(
                    "meeting_id" => $meeting_id,
                    "member_id" => $meeting['role'],
                    "position" => "chairman"
                )
            );

            $meeting_roles = array();
            foreach ($meeting['qualifications'] as $value) {
                $meeting_roles->array_push(
                    array(
                    "meeting_id" => $meeting_id,
                    "role_id" => $value
                ));
            }
            
            DB::table('meeting_roles')->insertGetId($meeting_roles);
        });
        
        return back()->with('output',$meeting['qualifications']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Meetings  $meetings
     * @return \Illuminate\Http\Response
     */
    public function show(Meetings $meetings)
    {
        $members = DB::table('users')
                        ->join('user_roles','users.id','=','user_roles.user_id')
                        ->join('roles','user_roles.role_id','=','roles.id')
                        ->join('meeting_members','user_roles.id','=','meeting_members.member_role_id')
                        ->select('users.first_name','users.last_name','roles.role_name','user_roles.user_id', 'meeting_members.position')
                        ->where('meeting_members.meeting_id',$meetings->id)
                        ->get();
        $creator = DB::table('users')
                        ->select('users.first_name','users.last_name')
                        ->where('users.id',$meetings->user_id)
                        ->get();

        $meetings->setMembers($members);
        $chair = $meetings->getChairman();
        $secr = $meetings->getSecretary();
        $chairman = ($chair === null)? 'Not Selected': $chair->last_name.' '.$chair->first_name;
        $secretary = ($secr === null)? 'Not Selected': $secr->last_name.' '.$secr->first_name;

        return view('meeting.show',["meeting" => $meetings, "members" => $members, "creator" => $creator[0],
         'chairman' => $chairman, 'secretary' => $secretary]);
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
        $schools = DB::table('schools')->get();
        $departments = DB::table('departments')->get();

        echo json_encode(["schools" => $schools, "departments" => $departments]);
    }
}
