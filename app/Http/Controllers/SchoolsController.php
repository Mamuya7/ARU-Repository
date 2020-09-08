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
        $name = $request->input('school_name');
        $code = $request->input('school_code');

        $schools->update([
            "school_name" => $name,
            "school_code" => $code
        ]);

        return redirect()->route('showschools');

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
            DB::table('schools')->where('id',$schools->id)->delete();
        });

        return back();
    }
    public function fetch()
    {
        $data = School::select('id','school_name as name','school_code as code')->get();
        echo json_encode($data);
    }
}
