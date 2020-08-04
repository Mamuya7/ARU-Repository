<?php

namespace App\Http\Controllers;
use App\Department;
use App\School;
use App\Directorate;
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
        // $departments = DB::table('departments')->paginate(10);
        // return view('department/index',['departments' => $departments]);
        
        $departments = DB::table('departments')
        ->join('department_school','departments.id','=','department_school.department_id')
        ->get();

        $directorates = DB::table('departments')
        ->join('department_directorate','department_directorate.department_id','=','departments.id')
        ->get();
        return view('department/index',['departments' => $departments, 'directorates' => $directorates]);
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
        $name = $request->input('department_name');
        $code = $request->input('department_code');
        $radio = $request->input('department-type');
        $school_directorate = $request->input('school_directorate_id');

        $id = DB::table('departments')->insertGetId(
            ['department_name' => $name, 'department_code' => $code]
        );

        if($radio == '1'){
            DB::table('department_school')->insert(
                ['school_id' => $school_directorate,'department_id' =>$id ]
            );
        }else{
            DB::table('department_directorate')->insert(
                ['directorate_id' => $school_directorate,'department_id' =>$id ]
            );
        }
           
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

    public function displaySChool(){
        $school = School::all();
        $directorate = Directorate::all();
        echo json_encode(['schools'=>$school,'directorates'=>$directorate]);
    }
}
