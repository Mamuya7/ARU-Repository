<?php

namespace App\Http\Controllers;

use App\DirectorateMeeting;
use Illuminate\Http\Request;

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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $result = ["heads" => array(), "staffs" => array(), "display" => "", "title" => "Create Directorate Meeting"];

        if(Auth::User()->hasRole('director')){

            $sch_id = Directorate::whereHas('departments',function(Builder $query){
                $query->where('id','=',Auth::User()->department_id);
            })->first()->id;

            $departments = Directorate::find($sch_id)->departments;

            foreach($departments as $department){
                foreach($department->users as $user){
                    if($user->hasRole('head')){
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
            $directorate_id = Directorate::whereHas('departments',function(Builder $query){
                            $query->where('id','=',Auth::User()->department_id);
                        })->first()->id;
    
            DirectorateMeeting::create([
                "meeting_id" => $meeting->id,
                "directorate_id" => $directorate_id,
                "secretary_id" => $request->input('secretary'),
                "meeting_time" => $request->input('time'),
            ]);
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
        //
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
    public function update(Request $request, DirectorateMeeting $directorateMeeting)
    {
        //
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
