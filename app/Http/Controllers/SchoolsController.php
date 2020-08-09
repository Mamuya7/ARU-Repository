<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Departments;
use App\School;
use Illuminate\Http\Request;

class SchoolsController extends Controller
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
        // $schools = DB::table('schools')->paginate(6);
        $schools = School::select(['id','school_name','school_code'])->withCount('departments')->paginate(6);
        return view('school/index',['schools' => $schools]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {    
            return view('school/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        School::create($request->all());

        return back()->with('response','New Student Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Schools  $schools
     * @return \Illuminate\Http\Response
     */
    public function show(School $school)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Schools  $schools
     * @return \Illuminate\Http\Response
     */
    public function edit(School $schools)
    {
        echo $schools;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Schools  $schools
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, School $schools)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Schools  $schools
     * @return \Illuminate\Http\Response
     */
    public function destroy(School $schools)
    {   
       
        DB::transaction(function() use($schools){

            DB::table('users')
            ->join('department_school','users.department_id','=','department_school.department_id')
            ->where('department_school.school_id','schools.id',$schools->id)->delete();
            DB::table('department_school')
            ->join('departments','department_school.department_id','=','departments.id')
            ->where('department_school.school_id','=',$schools->id)->delete();
            DB::table('schools')->where('schools.id',$schools->id)->delete();
        });
      
        return back();
    }
}
