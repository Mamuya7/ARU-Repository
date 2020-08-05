<?php

namespace App\Http\Controllers;

use App\Directorate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DirectoratesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $directorate = DB::table('directorates')->paginate();
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
     * @param  \App\Directorates  $directorate
     * @return \Illuminate\Http\Response
     */
    public function show(Directorate $directorate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Directorates  $directorate
     * @return \Illuminate\Http\Response
     */
    public function edit(Directorates $directorate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Directorates  $directorate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Directorates $directorate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Directorates  $directorate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Directorates $directorate)
    {
        //
    }
}
