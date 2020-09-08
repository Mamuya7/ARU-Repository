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
     $departments = Department::whereHasMorph('departmentable','App\School')->get();

        $directorates = Department::whereHasMorph('departmentable','App\Directorate')->get();
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


        if($radio == '1'){
            $department =  new Department(["department_code" => $code, "department_name" => $name]);
            $school = School::find($school_directorate);
            $school->departments()->save($department);
         
        }else{
            $department =  new Department(["department_code" => $code, "department_name" => $name]);
            $directorate = Directorate::find($school_directorate);
            $directorate->departments()->save($department);
           
        }
           
        return back()->with('response','New Student Added Successfully');
      

    }

    public function fetch()
    {
        echo Department::all();
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
        $isDirectorate = false;
        if($departments->departmentable->getMorphClass() == School::class){
            $isDirectorate = false;
            $parents =  School::all();
        }
        if($departments->departmentable->getMorphClass() == Directorate::class){
            $isDirectorate = true;
            $parents = Directorate::all();
        }
        echo json_encode(['department' => $departments, 'isDirectorate' => $isDirectorate,
         'parent' => $departments->departmentable, 'parents' => $parents]);
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
         DB::transaction(function() use($departments){
            DB::table('users')->where('department_id',$departments->id)->delete();           
            DB::table('department_meeting')->where('department_id',$departments->id)->delete(); 
            DB::table('departments')->where('id',$departments->id)->delete(); 
        });

        return redirect()->route('showDepartment');
       
    }
    public function departmentStaff(Department $departments)
    {  
        $data = Array();

        foreach ($departments->users as $user) {
            $data2 = ["user" => $user, "roles" => $user->roles];
            array_push($data,$data2);
        }
        echo json_encode($data);
    }
    public function academicDepartments()
    {  
        $data = Department::whereHasMorph('departmentable','App\School')
                ->select('id','department_name as name','department_code as code')->get();

        echo json_encode($data);
    }
    public function administrativeDepartments()
    {  
        $data = Department::whereHasMorph('departmentable','App\Directorate')
                ->select('id','department_name as name','department_code as code')->get();

        echo json_encode($data);
    }

    public function displaySChool(){
        $school = School::all();
        $directorate = Directorate::all();
        echo json_encode(['schools'=>$school,'directorates'=>$directorate]);
    }
}
