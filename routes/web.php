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

//Meeting routes
Route::get('view_meeting',function(){
    if(Auth::User()->hasRoleType('dean')){
        return redirect()->route('viewSchoolMeetings');
    }elseif (Auth::User()->hasRoleType('director')) {
        return redirect()->route('viewDirectorateMeetings');
    }elseif (Auth::User()->hasRoleType('system administrator')) {
        return redirect()->route('viewGeneralMeetings');
    }elseif (Auth::User()->hasAnyRoleType(['head','staff'])) {
        return redirect()->route('viewDepartmentMeetings');
    }else{
        return redirect()->route('viewDepartmentMeetings');
    }
});
Route::get('create_meeting',function(){
    if(Auth::User()->hasRoleType('dean')){
        return redirect()->route('createSchoolMeeting');
    }elseif (Auth::User()->hasRoleType('director')) {
        return redirect()->route('createDirectorateMeeting');
    }elseif (Auth::User()->hasRoleType('head')) {
        return redirect()->route('createDepartmentMeeting');
    }elseif (Auth::User()->hasRoleType('system administrator')) {
        return redirect()->route('createGeneralMeetings');
    }
});
Route::post('store_meeting',function(Request $request){
    if(Auth::User()->hasRoleType('dean')){
        return redirect()->route('storeSchoolMeeting',[$request]);
    }elseif (Auth::User()->hasRoleType('director')) {
        return redirect()->route('storeDirectorateMeeting',[$request]);
    }elseif (Auth::User()->hasRoleType('head')) {
        return redirect()->route('storeDepartmentMeeting',[$request]);
    }elseif (Auth::User()->hasRoleType('system administrator')) {
        return redirect()->route('storeGeneralMeetings',[$request]);
    }
});

// General Meeting routes
Route::get('create_general_meetings','MeetingsController@create')->name('createGeneralMeetings');
Route::get('view_general_meetings','MeetingsController@view')->name('viewGeneralMeetings');
Route::get('store_general_meetings','MeetingsController@store')->name('storeGeneralMeetings');
Route::post('update_general_meeting/{meeting}','MeetingsController@update');
Route::post('show_meeting/{meeting}','MeetingsController@show');
Route::post('downloadfile','MeetingsController@downloadFile');
Route::post('changesecretary/{meeting}','MeetingsController@changeSecretary');
Route::post('create_attendence/{meeting}','MeetingsController@submitAttendence');
Route::post('update_attendence/{meeting}','MeetingsController@updateAttendence');
Route::post('invitation_details','MeetingsController@invitation');

Route::post('show_users','UsersController@show');

// SchoolMeeting routes
Route::get('view_school_meetings','SchoolMeetingController@index')->name('viewSchoolMeetings');
Route::get('create_school_meeting','SchoolMeetingController@create')->name('createSchoolMeeting');
Route::get('show_school_meeting/{schoolMeeting}','SchoolMeetingController@show')->name('showSchoolMeeting');
Route::get('store_school_meeting','SchoolMeetingController@store')->name('storeSchoolMeeting');
Route::post('store_school_meeting_invitations/{schoolMeeting}','SchoolMeetingController@invite')->name('storeSchoolMeetingInvitation');

// DirectorateMeeting routes
Route::get('view_directorate_meeting','DirectorateMeetingController@index')->name('viewDirectorateMeetings');
Route::get('create_directorate_meeting','DirectorateMeetingController@create')->name('createDirectorateMeeting');
Route::get('show_directorate_meeting/{directorateMeeting}','DirectorateMeetingController@show')->name('showDirectorateMeeting');
Route::get('store_directorate_meeting','DirectorateMeetingController@store')->name('storeDirectorateMeeting');
Route::get('store_directorate_meeting_invitations/{directorateMeeting}','DirectorateMeetingController@invite')->name('storeDirectorateMeetingInvitation');

// DepartmentMeeting routes
Route::get('view_department_meeting','DepartmentMeetingController@index')->name('viewDepartmentMeetings');
Route::get('create_department_meeting','DepartmentMeetingController@create')->name('createDepartmentMeeting');
Route::get('show_department_meeting/{departmentMeeting}','DepartmentMeetingController@show')->name('showDepartmentMeeting');
Route::get('store_department_meeting','DepartmentMeetingController@store')->name('storeDepartmentMeeting');
Route::post('change_department_meeting_secretary/{departmentMeeting}','DepartmentMeetingController@changeSecretary');
Route::get('store_department_meeting_invitations/{departmentMeeting}','DepartmentMeetingController@invite')->name('storeDepartmentMeetingInvitation');

// Documents routes
Route::post('store_meeting_documents/{meeting}','DocumentsController@store')->name('storeMeetingDocuments');

// Departments
Route::get('AddDepartment', 'DepartmentsController@create')->name('AddDepartment');
Route::post('storeDepartment','DepartmentsController@store');
Route::get('showDepartment', 'DepartmentsController@index')->name('showDepartment');
Route::delete('deletedepartment/{departments}','DepartmentsController@destroy');
Route::post('editDepartment/{departments}','DepartmentsController@edit');
Route::post('showdirectoryschools','DepartmentsController@displaySChool')->name('showdirectoryschools');
Route::post('fetchdepartments','DepartmentsController@fetch');
Route::post('department_staff/{departments}','DepartmentsController@departmentStaff');

//schools
Route::get('showschools','SchoolsController@index')->name('showschools');
Route::get('AddSchool', 'SchoolsController@create')->name('AddSchool');
Route::post('storeschools', 'SchoolsController@store');
Route::delete('deleteschool/{schools}','SchoolsController@destroy');
Route::post('editSchool/{schools}','SchoolsController@edit');
Route::post('updateSchool/{schools}', 'SchoolsController@update');

//Committee Routes

Route::get('showsCommittee','CommitteeController@create')->name('showsCommittee');
Route::get('displayCommittee','CommitteeController@index')->name('displayCommittee');
Route::post('storesCommittee', 'CommitteeController@store');
Route::post('editCommittee/{committee}','CommitteeController@edit');
Route::post('updateCommittee/{committee}', 'CommitteeController@update');
Route::delete('deleteCommitee/{committee}','CommitteeController@destroy');
Route::get('assignCommittee','CommitteeController@display');
Route::post('committee_staff/{committee}','CommitteesController@committeeStaff');

// Route::get('commiteeUnasigned','CommitteeController@showUsers')->name('commiteeUnasigned');

// Committee roles
Route::get('createUserCommittee', 'CommitteeRoleController@create')->name('createUserCommittee');
Route::post('assignUserCommittee', 'CommitteeRoleController@store')->name('assignUserCommittee');
// Route::post('CommitteeMembers/{committeeUser}', 'CommitteeUserController@show')->name('CommitteeMembers');
Route::get('CommitteeMembers/{committee}','CommitteeRoleController@show')->name('CommitteeMembers');



//Roles
Route::get('registerRolesForm','RolesController@create')->name('registerRolesForm');
Route::get('displayRoles','RolesController@index')->name('displayRoles');
Route::post('storeRole', 'RolesController@store');
Route::post('editRole/{roles}','RolesController@edit');
Route::delete('deleteRole/{roles}','RolesController@destroy');
Route::post('updateRole', 'RolesController@updateRole');
Route::post('fetchroles', 'RolesController@fetch');
Route::post('roles_staff','RolesController@roleStaff');


//Directorate
Route::get('registerDirectorateForm','DirectoratesController@create')->name('registerDirectorateForm');
Route::post('storesDirectorate', 'DirectoratesController@store');
Route::get('displayDirectorates','DirectoratesController@index')->name('displayDirectorates');
Route::delete('deletedirectorate/{directorates}','DirectoratesController@destroy');
Route::post('editDirectorate/{directorates}','DirectoratesController@edit');
Route::post('updateDirectorate/{directorates}', 'DirectoratesController@update');
Route::post('directorate_staff/{directorate}','DirectoratesController@directorateStaff');



//users
Route::get('getUserRole/{id}','UserController@show')->name('getUserRole');
Route::get('viewUsers','UserController@index')->name('view-Users');
Route::post('assignRole', 'UserController@store');
Route::delete('deleteUser/{user}','UserController@destroy');
Route::post('editUser/{user}','UserController@edit');
Route::post('removeRole/{id}','UserController@removeRole');
Route::post('fetch_all_users','UserController@fetch');







// Route::get('showUser','User')
