<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Departments;
use App\Schools;
use Illuminate\Http\Request;

class SchoolsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $schools = Schools::All()->simplePaginate(1);
        // $schools = DB::table('schools')->simplePaginate(1);
        $schools = DB::table('schools')->paginate(2);
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
        Schools::create($request->all());

        return back()->with('response','New Student Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Schools  $schools
     * @return \Illuminate\Http\Response
     */
    public function show(Schools $schools)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Schools  $schools
     * @return \Illuminate\Http\Response
     */
    public function edit(Schools $schools)
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
    public function update(Request $request, Schools $schools)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Schools  $schools
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schools $schools)
    {   
        DB::transaction(function() use($schools){
            DB::table('users')
            ->join('departments','users.department_id','=','departments.id')
            ->join('schools','departments.school_id','=','schools.id')
            ->where('departments.school_id',$schools->id)->delete(); 
            DB::table('departments')->where('school_id',$schools->id)->delete();
            DB::table('schools')->where('id',$schools->id)->delete();
        });

        
        return redirect('showschools');
    }
}
