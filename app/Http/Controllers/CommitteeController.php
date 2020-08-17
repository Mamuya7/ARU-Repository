<?php

namespace App\Http\Controllers;
use App\Committee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommitteeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $committee = DB::table('committees')->paginate(8);
        return view('committee.indexpage',['committees' => $committee]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('committee/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Committee::create($request->all());

        return back()->with('response','New Committee Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Committee  $committee
     * @return \Illuminate\Http\Response
     */
    public function show(Committee $committee)
    {
        return view('committee/index');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Committee  $committee
     * @return \Illuminate\Http\Response
     */
    public function edit(Committee $committee)
    {
        echo $committee;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Committee  $committee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Committee $committee)
    {  
        $name = $request->input('committee_name');
        $code = $request->input('committee_code');

        $committee->update([
            "committee_name" => $name,
            "committee_code" => $code
        ]);

        return redirect()->route('displayCommittee');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Committee  $committee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Committee $committee)
    {
        DB::transaction(function() use($committee){
            DB::table('committees')->where('id', $committee->id)->delete();
        });

        return back();
    }
    public function committeeStaff(Committee $committee)
    {  
        $data = Array();

        foreach ($committee->roles as $role) {
            foreach ($role->users as $user) {
                $data2 = ["user" => $user, "roles" => $user->roles];
                array_push($data,$data2);
            }
        }
        echo json_encode($data);
    }
}
