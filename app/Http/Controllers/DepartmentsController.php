<?php

namespace App\Http\Controllers;

use App\Department;
// use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartmentsController extends Controller
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
        $departments = DB::table('departments')->paginate(10);
        return view('department/index',['departments' => $departments]);
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('department.create'); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  
        Department::create($request->all());
        return back()->with('response','New Student Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Departments  $departments
     * @return \Illuminate\Http\Response
     */
    public function show(Department $departments)
    {   
        // $departments = DB::table('departments')
        // ->join('schools','departments.school_id','=','schools.id')
        // ->select('departments.*','schools.school_name as school_name','schools.school_code as school_code')
        // ->paginate(2);
        // return view('department/index',['departments' => $departments]);
      
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Departments  $departments
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $departments)
    {
        // $school = DB::table('schools')->get();
        //echo json_encode(["department" => $departments]);
        echo $departments;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Departments  $departments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $departments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Departments  $departments
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $departments)
    {
        //  DB::transaction(function() use($departments){
        //     DB::table('users')->where('department_id',$departments->id)->delete(); 
        //     DB::table('departments')->where('id',$departments->id)->delete(); 
        // });

        // return redirect('showDepartment');
    }
}
