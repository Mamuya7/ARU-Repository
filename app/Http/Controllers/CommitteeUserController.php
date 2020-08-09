<?php

namespace App\Http\Controllers;

use App\Committee;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class CommitteeUserController extends Controller
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
        
        $users = DB::table('departments')
        ->join('users','users.department_id','=','departments.id')
        ->select(DB::raw('CONCAT(users.first_name," ",users.last_name) as full_name'),'users.id as user_id','departments.department_name as department')
        ->paginate(10);

        $committee = DB::table('committees')->paginate(10);


        return view('committee/assignCommittee',['user' => $users,'committee'=>$committee]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $staffs = $request->input('user_id');
        $committee_id = $request->input('committee');

        Committee::find($committee_id)->users()->attach($staffs);
        
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CommitteeUser  $committeeUser
     * @return \Illuminate\Http\Response
     */
    public function show(CommitteeUser $committeeUser)
    {
        // 
    }

    public function display($id)
    {
        $committeeUsers = Committee::find($id)->users;
        echo json_encode($committeeUsers);
    
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CommitteeUser  $committeeUser
     * @return \Illuminate\Http\Response
     */
    public function edit(CommitteeUser $committeeUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CommitteeUser  $committeeUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CommitteeUser $committeeUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CommitteeUser  $committeeUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(CommitteeUser $committeeUser)
    {
        //
    }
}
