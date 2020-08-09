<?php

namespace App\Http\Controllers;

use App\Directorate;
// use DB;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DirectoratesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $directorate = DB::table('directorates')->paginate();
        $directorate = Directorate::select(['id','directorate_name','directorate_code'])->withCount('departments')->paginate(10);
        return view('directorate.index',['directorates' => $directorate]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('directorate.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Directorate::create($request->all());
        return back()->with('response','New Role Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Directorates  $directorates
     * @return \Illuminate\Http\Response
     */
    public function show(Directorates $directorates)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Directorates  $directorates
     * @return \Illuminate\Http\Response
     */
    public function edit(Directorates $directorates)
    {
            echo $directorates;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Directorates  $directorates
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Directorates $directorates)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Directorates  $directorates
     * @return \Illuminate\Http\Response
     */
    public function destroy(Directorates $directorates)
    {
        DB::transaction(function() use($directorates){
            DB::table('directorates')->where('id',$directorates->id)->delete();
        });
        
        return redirect('displayDirectorates');
       
    }
}







