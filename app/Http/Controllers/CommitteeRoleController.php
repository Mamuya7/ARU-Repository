<?php

namespace App\Http\Controllers;
use App\Committee;
use App\CommitteeRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommitteeRoleController extends Controller
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
        
        $roles = DB::table('roles')->get();

        $committee = DB::table('committees')->paginate(9);


        return view('committee/assignCommittee',['roles' => $roles,'committees'=>$committee]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $roles = $request->input('role_id');
        $committee_id = $request->input('committee');

        Committee::find($committee_id)->roles()->attach($roles);
        
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CommitteeRole  $committeeRole
     * @return \Illuminate\Http\Response
     */
    public function show(Committee $committee)
    {
       
       echo json_encode($committee->committeeUsers());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CommitteeRole  $committeeRole
     * @return \Illuminate\Http\Response
     */
    public function edit(CommitteeRole $committeeRole)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CommitteeRole  $committeeRole
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CommitteeRole $committeeRole)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CommitteeRole  $committeeRole
     * @return \Illuminate\Http\Response
     */
    public function destroy(CommitteeRole $committeeRole)
    {
        //
    }
}
