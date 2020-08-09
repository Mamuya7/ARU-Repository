<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Department;
use App\Roles;
use App\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
        $users = DB::table('departments')
        ->join('users','users.department_id','=','departments.id')
        ->select(DB::raw('CONCAT(users.first_name," ",users.last_name) as full_name'),'users.id as id','users.gender as gender','users.email as email','departments.department_name as department')
        ->get();

        
        $roles = DB::table('roles')->get();


        return view('user.index',['user' => $users,'roles'=>$roles]);
    //    return view('user.index');
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
        ->select(DB::raw('CONCAT(users.first_name," ",users.last_name) as full_name'),'users.email as email','departments.department_name as department')
        ->get();

        return view('user.roleUser',['user' => $users,'role'=>$roles]);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $roles = User::find($id)->roles;
        $role = DB::table('roles')->get();
        echo json_encode($roles);
    
        // return view('department/index',['departments' => $departments])
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
