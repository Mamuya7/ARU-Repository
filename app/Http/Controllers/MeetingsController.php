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
        return view('meeting.create');
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

            DB::table('meeting_members')->insertGetId(
                array(
                    "meeting_id" => $meeting_id,
                    "member_role_id" => $meeting['role'],
                    "position" => "chairman"
                )
            );
        });
        
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Meetings  $meetings
     * @return \Illuminate\Http\Response
     */
    public function show(Meetings $meetings)
    {
        //
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
}
