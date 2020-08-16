<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\School;
use App\Directorate;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::User()->hasRoleType('system administrator')){
            return view('home.admin');
        }else{
            $past = $this->pastDepartmentMeetingsCount();
            $past += $this->pastSchoolMeetingsCount();
            $past += $this->pastDirectorateMeetingsCount();

            $coming = $this->comingDepartmentMeetingsCount();
            $coming += $this->comingSchoolMeetingsCount();
            $coming += $this->comingDirectorateMeetingsCount();

            $attended = $this->attendedMeetingsCount();
            $missed = $this->missedMeetingsCount();
            $abscent = $this->abscentMeetingsCount();

            $all = $past + $coming;
        }
        
        return view('home.staff',[
                        "past_meetings" => $past,
                        "coming_meetings" => $coming,
                        "all_meetings" => $all,
                        "attended_meetings" => $attended,
                        "abscent_meetings" => $abscent,
                        "missed_meetings" => $missed
                    ]);
    }

    public function pastDepartmentMeetingsCount()
    {
        return Auth::User()->department->meetings()->whereDate('meeting_date','<',date('Y-m-d'))->count();
    }
    public function comingDepartmentMeetingsCount()
    {
        return Auth::User()->department->meetings()->whereDate('meeting_date','>=',date('Y-m-d'))->count();
    }
    public function pastSchoolMeetingsCount()
    {
        if(Auth::User()->hasAnyRoleType(['head','dean']) && Auth::User()->department->belongsToSchool()){
            return School::find(Auth::User()->department->departmentable_id)->meetings()->whereDate('meeting_date','<',date('Y-m-d'))->count();
        }
        return 0;
    }
    public function comingSchoolMeetingsCount()
    {
        if(Auth::User()->hasAnyRoleType(['head','dean']) && Auth::User()->department->belongsToSchool()){
            return School::find(Auth::User()->department->departmentable_id)->meetings()->whereDate('meeting_date','>=',date('Y-m-d'))->count();
        }
        return 0;
    }
    public function pastDirectorateMeetingsCount()
    {
        if(Auth::User()->hasRoleType('director')){
            $directorate = Directorate::withDirectorAs(Auth::User()->roles()->where('role_type','director')->first()->role_code);
            return $directorate->meetings()->whereDate('meeting_date','<',date('Y-m-d'))->count();
        }elseif(Auth::User()->hasRoleType('head') && Auth::User()->department->belongsToDirectorate()){
            return Directorate::find(Auth::User()->department->departmentable_id)->meetings()->whereDate('meeting_date','<',date('Y-m-d'))->count();
        }
        return 0;
    }
    public function comingDirectorateMeetingsCount()
    {
        if(Auth::User()->hasRoleType('director')){
            $directorate = Directorate::withDirectorAs(Auth::User()->roles()->where('role_type','director')->first()->role_code);
            return $directorate->meetings()->whereDate('meeting_date','>=',date('Y-m-d'))->count();
        }elseif(Auth::User()->hasRoleType('head') && Auth::User()->department->belongsToDirectorate()){
            return Directorate::find(Auth::User()->department->departmentable_id)->meetings()->whereDate('meeting_date','>=',date('Y-m-d'))->count();
        }
        return 0;
    }

    public function attendedMeetingsCount()
    {
        return Auth::User()->attendences()->where("status","attended")->count();
    }
    public function abscentMeetingsCount()
    {
        return Auth::User()->attendences()->where("status","missed")->count();
    }
    public function missedMeetingsCount()
    {
        return Auth::User()->attendences()->where("status","noreport")->count();
    }
    public function invitedMeetingsCount()
    {
        return Auth::User()->invitations()->count();
    }
}
