<?php

namespace App\Http\Controllers;

use App\Directorate;
use App\Roles;;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DirectoratesController extends Controller
{  /**
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
        $roles = Roles::where('role_type','director')->get();
        $directorate = Directorate::select(['id','directorate_name','directorate_code','directorate_head'])->withCount('departments')->paginate(10);
        return view('directorate.index',['directorates' => $directorate, "roles" => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Roles::where('role_type','director')->get();
        return view('directorate.create',["roles" => $roles]);
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
    public function edit(Directorate $directorates)
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
    public function update(Request $request, Directorate $directorates)
    {
            $name = $request->input('directorate_name');
            $code = $request->input('directorate_code');
            $head = $request->input('directorate_head');

            $directorates->update([
                "directorate_name" => $name,
                "directorate_code" => $code,
                "directorate_head" => $head
            ]);

            return redirect()->route('displayDirectorates');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Directorates  $directorates
     * @return \Illuminate\Http\Response
     */
    public function destroy(Directorate $directorates)
    {
        DB::transaction(function() use($directorates){
            DB::table('directorates')->where('id',$directorates->id)->delete();
        });
        
        return redirect('displayDirectorates');
       
    }
    public function directorateStaff(Directorate $directorate)
    {  
        $data = Array();

        foreach ($directorate->departments as $department) {
            foreach ($department->users as $user) {
                $data2 = ["user" => $user, "roles" => $user->roles];
                array_push($data,$data2);
            }
        }
        echo json_encode($data);
    }
}







