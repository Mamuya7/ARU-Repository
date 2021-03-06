<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use App\Department;
use App\Roles;
use Auth;
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
    public function store(Request $request, User $user)
    {
        // $userId = $request->input('userId');
        $roleId = $request->input('roles_id');

        $user->roles()->sync($roleId);

        // return redirect('viewUsers');
        echo json_encode($user->roles);
            // echo json_encode("Role inserted successifully");
        
        // return redirect('viewUsers');
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {   
        $userroles = $user->roles;

        $otherroles = Roles::all()->except($user->roles()->pluck("role_id")->toArray());

        echo json_encode(['roles'=>$userroles,'otherroles' => $otherroles,'users'=>$user]);
    
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
       // $users = DB::table('users')
       // ->join('departments','departments.id','=','users.department_id')
        //->where('users.id','=',$user->id)
        //->first();
        //echo json_encode($users);
        echo $user;
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
    public function update(Request $request, User $user)
    {
        //$first_name = $request->input('first_name');
        //$last_name = $request->input('last_name');
       // $gender = $request->input('gender');
        $email = $request->input('email');
        $department = $request->input('department');

        $user->update([
           // 'first_name' => $first_name,
            //'last_name' => $last_name,
            //'gender' => $gender,
            'email' => $email,
            'department_id' => $department
        ]);
        return back();
        
        //return redirect('viewUsers');
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


    public function userProfile()
    {   
       $user= Auth::User();
       //dd($user);

        $users = DB::table('departments')
        ->join('users','users.department_id','=','departments.id')
        ->select('users.id as user_id','users.*','departments.*')
        ->where('users.id',$user->id)
        ->get();

        //dd($users);
        
        $roles = DB::table('roles')->get();
        $departments = DB::table('departments')->get();

        if(Auth::User()->hasRoleType('system administrator')){
             return view('profile.staffProfile',['user' => $users,'roles'=>$roles,'departments'=>$departments]);
        }
        else{
             return view('profile.staffAllProfile',['user' => $users,'roles'=>$roles,'departments'=>$departments]);
        }
       
    }

    public function updateProfile(Request $request)
    {   
        $id = $request->input('id');
        $email = $request->input('email');
        //$password = $request->input('password');
       // $department = $request->input('department');
        $password = Hash::make($request->input('password'));
        //dd($id);

    
        DB::table('users')
              ->where('id', $id)
              ->update(['email' => $email,
                        'password'=>$password
              ]);
        return back();
        
    }



    




}
