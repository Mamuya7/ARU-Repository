<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Department;
use App\Roles;
use App\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
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
        $users = DB::table('departments')
        ->join('users','users.department_id','=','departments.id')
        ->select(DB::raw('CONCAT(users.first_name," ",users.last_name) as full_name'),'users.id as id','users.gender as gender','users.email as email','departments.department_name as department')
        ->paginate(10);

        
        $roles = DB::table('roles')->get();
        $departments = DB::table('departments')->get();


        return view('user.index',['user' => $users,'roles'=>$roles,'departments'=>$departments]);
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
        $userId = $request->input('userId');
        $roleId = $request->input('roles');

        User::find($userId)->roles()->attach($roleId);

        return redirect('viewUsers');
        
            // echo json_encode("Role inserted successifully");
        
        // return redirect('viewUsers');
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        $user = $id;
        $roles = User::find($id)->roles;
        $role = DB::table('roles')->get();
        echo json_encode(['roles'=>$roles,'users'=>$user]);
    
        // return view('department/index',['departments' => $departments])
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $users = DB::table('users')
        ->join('departments','departments.id','=','users.department_id')
        ->where('users.id','=',$user->id)
        ->first();
        echo json_encode($users);
    }

    public function fetch()
    {
        $data = Array();
        foreach (User::all() as $user) {
            $data2 = Array("user" => $user, "roles" => $user->roles);
            array_push($data,$data2);
        }
        echo json_encode($data);
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
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {     
        DB::transaction(function() use($user){
            DB::table('role_user')->where('user_id',$user->id)->delete();    
            DB::table('users')->where('id',$user->id)->delete();                
        });
        return back();
    }

    public function removeRole(Request $request,$id){
        $userId = $request->input('userID');
        // consol($userId);

        User::find($userId)->roles()->detach($id);
        echo json_encode('successifully');
    }
}
