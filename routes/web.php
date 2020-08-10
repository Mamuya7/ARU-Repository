<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();


Route::get('/home', 'HomeController@index')->name('home');

// Meeting routes
Route::get('create_meeting','MeetingsController@create');
Route::get('view_meeting','MeetingsController@index')->name('view_meetings');
Route::post('store_meeting',function(Request $request){
    if(Auth::User()->hasRole('dean')){
        return redirect()->route('storeSchoolMeeting',[$request]);
    }elseif (Auth::User()->hasRole('director')) {
        return redirect()->route('storeDirectorateMeeting',[$request]);
    }elseif (Auth::User()->hasRole('head')) {
        return redirect()->route('storeDepartmentMeeting',[$request]);
    }elseif (Auth::User()->hasRole('system administrator')) {
        return redirect()->route('storeGeneralMeeting');
    }
});
Route::post('fetch_meeting_members','MeetingsController@fetch');
Route::post('show_meeting/{meeting}','MeetingsController@show');
Route::post('uploadfile/{meeting}','MeetingsController@uploadFile');
Route::post('downloadfile','MeetingsController@downloadFile');
Route::post('changesecretary/{meeting}','MeetingsController@changeSecretary');
Route::post('create_attendence/{meeting}','MeetingsController@createAttendence');

Route::post('show_users','UsersController@show');

// SchoolMeeting routes
Route::get('view_school_meetings','SchoolMeetingController@index')->name('viewSchoolMeetings');
Route::get('create_school_meeting','SchoolMeetingController@create')->name('createSchoolMeeting');
Route::post('show_school_meeting/{schoolmeeting}','SchoolMeetingController@show');
Route::get('store_school_meeting','SchoolMeetingController@store')->name('storeSchoolMeeting');

// DirectorateMeeting routes
Route::get('view_directorate_meeting','DirectorateMeetingController@index')->name('viewDirectorateMeetings');
Route::get('create_directorate_meeting','DirectorateMeetingController@create')->name('createDirectorateMeeting');
Route::post('show_directorate_meeting/{directoratemeeting}','DirectorateMeetingController@show');
Route::get('store_directorate_meeting','DirectorateMeetingController@store')->name('storeDirectorateMeeting');

// DepartmentMeeting routes
Route::get('view_department_meeting','DepartmentMeetingController@index')->name('viewDepartmentMeetings');
Route::get('create_department_meeting','DepartmentMeetingController@create')->name('createDepartmentMeeting');
Route::post('show_department_meeting/{departmentmeeting}','DepartmentMeetingController@show');
Route::get('store_department_meeting','DepartmentMeetingController@store')->name('storeDepartmentMeeting');

// Departments
Route::get('AddDepartment', 'DepartmentsController@create')->name('AddDepartment');
Route::post('storeDepartment','DepartmentsController@store');
Route::get('showDepartment', 'DepartmentsController@index')->name('showDepartment');
Route::delete('deletedepartment/{departments}','DepartmentsController@destroy');
Route::post('editDepartment/{departments}','DepartmentsController@edit');
Route::post('showdirectoryschools','DepartmentsController@displaySChool')->name('showdirectoryschools');

//schools
Route::get('showschools','SchoolsController@index')->name('showschools');
Route::get('AddSchool', 'SchoolsController@create')->name('AddSchool');
Route::post('storeschools', 'SchoolsController@store');
Route::delete('deleteschool/{schools}','SchoolsController@destroy');
Route::post('editSchool/{schools}','SchoolsController@edit');

//Committee Routes

Route::get('showsCommittee','CommitteeController@create')->name('showsCommittee');
Route::get('displayCommittee','CommitteeController@index')->name('displayCommittee');
Route::post('storesCommittee', 'CommitteeController@store');
Route::post('editCommittee/{committee}','CommitteeController@edit');
Route::post('updateCommittee/{committee}', 'CommitteeController@update');
Route::delete('deleteCommitee/{committee}','CommitteeController@destroy');
Route::get('assignCommittee','CommitteeController@display');
// Route::post('AssignMembersCommittee', 'CommitteeController@asignMemberCommittee');

// Route::get('commiteeUnasigned','CommitteeController@showUsers')->name('commiteeUnasigned');

// Committee users
Route::get('createUserCommittee', 'CommitteeUserController@create')->name('createUserCommittee');
Route::post('assignUserCommittee', 'CommitteeUserController@store')->name('assignUserCommittee');
// Route::post('CommitteeMembers/{committeeUser}', 'CommitteeUserController@show')->name('CommitteeMembers');
Route::get('CommitteeMembers/{id}','CommitteeUserController@display')->name('CommitteeMembers');



//Roles
Route::get('registerRolesForm','RolesController@create')->name('registerRolesForm');
Route::get('displayRoles','RolesController@index')->name('displayRoles');
Route::post('storeRole', 'RolesController@store');
Route::post('editRole/{roles}','RolesController@edit');
Route::delete('deleteRole/{roles}','RolesController@destroy');
Route::post('updateRole', 'RolesController@updateRole');



//Directorate
Route::get('registerDirectorateForm','DirectoratesController@create')->name('registerDirectorateForm');
Route::post('storesDirectorate', 'DirectoratesController@store');
Route::get('displayDirectorates','DirectoratesController@index')->name('displayDirectorates');
Route::delete('deletedirectorate/{directorates}','DirectoratesController@destroy');
Route::post('editDirectoratee/{directorate}','DirectoratesController@edit');




//users
Route::get('getUserRole/{id}','UserController@show')->name('getUserRole');
Route::get('viewUsers','UserController@index')->name('viewUsers');



// Route::get('showUser','User')
