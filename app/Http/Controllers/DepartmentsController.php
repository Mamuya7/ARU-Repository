<?php

namespace App\Http\Controllers;

use App\Departments;
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $school_name = DB::table('Schools')->get();
        return view('department/create',['schools_name'=>$school_name]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = new Departments([
            'department_name' =>$request->get('department_name'),
            'department_code' =>$request->get('department_code'),
            'school_id' =>$request->get('school_id')
        ]);    
        $data->save();        
        return view('department/create')->with('response','New Student Added Successfully');   
        
        // $departments = $request->all();
        // DB::transaction(function() use($departments){
        //     $department_id = DB::table('departments')
        //                     ->insertGetId(
        //                         array(
        //                             "department_name" => $departments['department_name'],
        //                             "department_code" => $departments['department_code'],
        //                             "school_id" =>$departments["school_id"]
        //                         ));
        // });

        

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Departments  $departments
     * @return \Illuminate\Http\Response
     */
    public function show(Departments $departments)
    {   
        $departments = DB::table('departments')
        ->join('schools','departments.school_id','=','schools.id')
        ->select('departments.*','schools.school_name as school_name','schools.school_code as school_code')
        ->paginate(2);
        return view('department/index',['departments' => $departments]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Departments  $departments
     * @return \Illuminate\Http\Response
     */
    public function edit(Departments $departments)
    {
        $school = DB::table('schools')->get();
        echo json_encode(["department" => $departments,'schools' => $school]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Departments  $departments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Departments $departments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Departments  $departments
     * @return \Illuminate\Http\Response
     */
    public function destroy(Departments $departments)
    {
         DB::transaction(function() use($departments){
            DB::table('users')->where('department_id',$departments->id)->delete(); 
            DB::table('departments')->where('id',$departments->id)->delete(); 
        });

        return redirect('showDepartment');
    }
}
