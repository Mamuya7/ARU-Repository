<?php

namespace App\Http\Controllers;

use App\CommitteeMeeting;
use Illuminate\Http\Request;

class CommitteeMeetingController extends Controller
{
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CommitteeMeeting  $committeeMeeting
     * @return \Illuminate\Http\Response
     */
    public function show(CommitteeMeeting $committeeMeeting)
    {
        $roles = $committeeMeeting->committee->roles();
        $invitees = $committeeMeeting->invitations;
        $attendence = $committeeMeeting->attendences;
        $members = Array(); $invitations = Array();
        $chairman = ($roles->where("position","chairman")->count() > 0)? $roles->where("position","chairman")->first()->user->first(): null;
        $secretary = ($roles->where("position","secretary")->count() > 0)? $roles->where("position","secretary")->first()->user->first(): null;
        
        foreach ($committeeMeeting->committee->committeeUsers() as $user) {
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
        if(sizeof($invitees) > 0){
            foreach ($invitees as $value) {
                $data = array(
                    "profile" => User::find($value->user_id), 
                    "role" => Roles::find($value->role_id), 
                    "invitation" => $value
                );
                
                array_push($invitations,$data);
            }
        }

        return view('meeting.show',[ 
            "resources" => [
                "chairman" => $chairman,
                "secretary" => $secretary, 
                "members" => $members,
                "specificMeeting" => $committeeMeeting,
                "documents" => $committeeMeeting->documents,
                "invites" => $invitations,
                "urls" => [
                    "change_secretary" => "change_committee_meeting_secretary",
                    "set_attendence" => json_encode(url("set_committee_meeting_attendence/".$committeeMeeting->id)),
                    "update_attendence" => json_encode(url("update_committee_meeting_attendence/".$committeeMeeting->id)),
                    "invitation_link" => url('store_committee_meeting_invitations/'.$committeeMeeting->id)
                ]
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CommitteeMeeting  $committeeMeeting
     * @return \Illuminate\Http\Response
     */
    public function edit(CommitteeMeeting $committeeMeeting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CommitteeMeeting  $committeeMeeting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CommitteeMeeting $committeeMeeting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CommitteeMeeting  $committeeMeeting
     * @return \Illuminate\Http\Response
     */
    public function destroy(CommitteeMeeting $committeeMeeting)
    {
        //
    }

    public function updateAttendence(Request $request, CommitteeMeeting $committeeMeeting){
        $data = $request->input('data');
        DB::transaction(function() use($data,$committeeMeeting){
            
            DB::table('attendences')
            ->updateOrInsert(
                ["user_id" => intVal($data['user_id']), "attendenceable_id" => $committeeMeeting->id, "attendenceable_type" => 'App\CommitteeMeeting'],
                ["user_id" => intVal($data['user_id']),"status" => $data['status']]
            );
        });
        
        echo json_encode($data);
    }

    public function setAttendence(Request $request, CommitteeMeeting $committeeMeeting){
        $data = $request->input('data');

        DB::transaction(function() use($data,$committeeMeeting){
            foreach ($data as $status => $users) {
                foreach ($users as $user) {
                    DB::table('attendences')
                    ->updateOrInsert(
                        ["user_id" => intVal($user), "attendenceable_id" => $committeeMeeting->id, "attendenceable_type" => 'App\CommitteeMeeting'],
                        ["user_id" => intVal($user),"status" => $status]
                    );
                }
            }
        });

        echo json_encode($data);
    }
}
