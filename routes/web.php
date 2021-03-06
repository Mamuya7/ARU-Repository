<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;

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


// Route::get('/send-mail', function () {
//         $details = [
//          'title'=>'mail from Ardhi university',
//          'body'=>'This for notifying of meeting issues'
//          ];

//          $data = array('mankilla12345@gmail.com','kilango12345@gmail.com');
         
//              \Mail::to($data)->send(new \App\Mail\MeetingCreated($details));
//              echo "email sent successiffully";
       
// });

// \Mail::send(['text'=>'mail'], $details, function($message) {
//     $message->to('mankilla12345@gmail.com', 'Kilango Ramadhani')->subject
//        ('Laravel Basic Testing Mail');
//     $message->from('kilango12345@gmail.com','Ramadhani Kilango');
//  });
//  echo "Basic Email Sent. Check your inbox.";





    // $data = array('mankilla123452gmail.com','kilango123452gmail.com');
   
    // Mail::send(['email.meetingCreated'], $data, function($message) use($data){
    //     // $message->from('');

    //     $message->to($data)->subject('This is test e-mail'); 
    // });



Auth::routes();


Route::get('/home', 'HomeController@index')->name('home');

//Meeting routes
Route::get('view_meeting',function(){
    if(Auth::User()->hasRoleType('dean')){
        return redirect()->route('viewSchoolMeetings');
    }elseif(Auth::User()->hasRoleType('administrative')){
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
Route::post('downloadfile/{document}','MeetingsController@downloadFile');
Route::post('changesecretary/{meeting}','MeetingsController@changeSecretary');
Route::post('invitation_details','MeetingsController@invitation');
Route::post('navnext/{meeting}','MeetingsController@next');
Route::post('navback/{meeting}','MeetingsController@back');

Route::post('show_users','UsersController@show');

// SchoolMeeting routes
Route::get('view_school_meetings','SchoolMeetingController@index')->name('viewSchoolMeetings');
Route::get('create_school_meeting','SchoolMeetingController@create')->name('createSchoolMeeting');
Route::any('show_school_meeting/{schoolMeeting}','SchoolMeetingController@show')->name('showSchoolMeeting');
Route::get('store_school_meeting','SchoolMeetingController@store')->name('storeSchoolMeeting');
Route::post('store_school_meeting_invitations/{schoolMeeting}','SchoolMeetingController@invite')->name('storeSchoolMeetingInvitation');
Route::post('search_school_meetings','SchoolMeetingController@search')->name('searchSchoolMeetings');
Route::post("set_school_meeting_attendence/{schoolMeeting}",'SchoolMeetingController@setAttendence');
Route::post("update_school_meeting_attendence/{schoolMeeting}",'SchoolMeetingController@updateAttendence');
Route::post("submit_school_meeting_attendence/{schoolMeeting}",'SchoolMeetingController@submitAttendence');

// DirectorateMeeting routes
Route::get('view_directorate_meeting','DirectorateMeetingController@index')->name('viewDirectorateMeetings');
Route::get('create_directorate_meeting','DirectorateMeetingController@create')->name('createDirectorateMeeting');
Route::any('show_directorate_meeting/{directorateMeeting}','DirectorateMeetingController@show')->name('showDirectorateMeeting');
Route::get('store_directorate_meeting','DirectorateMeetingController@store')->name('storeDirectorateMeeting');
Route::post('change_directorate_meeting_secretary/{directorateMeeting}','DirectorateMeetingController@changeSecretary');
Route::post('store_directorate_meeting_invitations/{directorateMeeting}','DirectorateMeetingController@invite')->name('storeDirectorateMeetingInvitation');
Route::post('search_directorate_meetings','DirectorateMeetingController@search')->name('searchDirectorateMeetings');
Route::post("set_directorate_meeting_attendence/{directorateMeeting}",'DirectorateMeetingController@setAttendence');
Route::post("update_directorate_meeting_attendence/{directorateMeeting}",'DirectorateMeetingController@updateAttendence');
Route::post("submit_directorate_meeting_attendence/{directorateMeeting}",'DirectorateMeetingController@submitAttendence');

// DepartmentMeeting routes
Route::get('view_department_meeting','DepartmentMeetingController@index')->name('viewDepartmentMeetings');
Route::get('create_department_meeting','DepartmentMeetingController@create')->name('createDepartmentMeeting');
Route::any('show_department_meeting/{departmentMeeting}','DepartmentMeetingController@show')->name('showDepartmentMeeting');
Route::get('store_department_meeting','DepartmentMeetingController@store')->name('storeDepartmentMeeting');
Route::post('change_department_meeting_secretary/{departmentMeeting}','DepartmentMeetingController@changeSecretary');
Route::post('store_department_meeting_invitations/{departmentMeeting}','DepartmentMeetingController@invite')->name('storeDepartmentMeetingInvitation');
Route::post('search_department_meetings','DepartmentMeetingController@search')->name('searchDepartmentMeetings');
Route::post("set_department_meeting_attendence/{departmentMeeting}",'DepartmentMeetingController@setAttendence');
Route::post("update_department_meeting_attendence/{departmentMeeting}",'DepartmentMeetingController@updateAttendence');
Route::post("submit_department_meeting_attendence/{departmentMeeting}",'DepartmentMeetingController@submitAttendence');

// CommitteeMeeting routes
Route::post('show_committee_meeting/{committeeMeeting}','CommitteeMeetingController@show')->name('showCommitteeMeeting');
Route::post("set_committee_meeting_attendence/{committeeMeeting}",'CommitteeMeetingController@setAttendence');
Route::post("update_committee_meeting_attendence/{committeeMeeting}",'CommitteeMeetingController@updateAttendence');

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
Route::post('fetch_academic_departments','DepartmentsController@academicDepartments');
Route::post('fetch_administrative_departments','DepartmentsController@administrativeDepartments');
Route::post('department_staff/{departments}','DepartmentsController@departmentStaff');

//schools
Route::get('showschools','SchoolsController@index')->name('showschools');
Route::get('AddSchool', 'SchoolsController@create')->name('AddSchool');
Route::post('storeschools', 'SchoolsController@store');
Route::delete('deleteschool/{schools}','SchoolsController@destroy');
Route::post('editSchool/{schools}','SchoolsController@edit');
Route::post('updateSchool/{schools}', 'SchoolsController@update');
Route::post('fetch_schools', 'SchoolsController@fetch');

//Committee Routes

Route::get('showsCommittee','CommitteeController@create')->name('showsCommittee');
Route::get('displayCommittee','CommitteeController@index')->name('displayCommittee');
Route::post('storesCommittee', 'CommitteeController@store');
Route::post('editCommittee/{committee}','CommitteeController@edit');
Route::post('updateCommittee/{committee}', 'CommitteeController@update');
Route::delete('deleteCommitee/{committee}','CommitteeController@destroy');
Route::post('fetch_committees', 'CommitteeController@fetch');
Route::get('assignCommittee','CommitteeController@display');
Route::post('committee_staff/{committee}','CommitteeController@committeeStaff');

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
Route::post('fetch_directorates', 'DirectoratesController@fetch');
Route::post('directorate_staff/{directorate}','DirectoratesController@directorateStaff');



//users
Route::get('getUserRole/{user}','UserController@show')->name('getUserRole');
Route::get('viewUsers','UserController@index')->name('view-Users');
Route::post('assign_user_role/{user}', 'UserController@store');
Route::delete('deleteUser/{user}','UserController@destroy');
Route::post('editUser/{user}','UserController@edit');
Route::post('removeRole/{id}','UserController@removeRole');
Route::post('fetch_all_users','UserController@fetch');
Route::post('updateUser/{user}', 'UserController@update');



//userProfile
Route::get('viewProfile','UserController@userProfile');
Route::post('updateProfile', 'UserController@updateProfile');

//invitations
Route::delete('delete_invitation/{invitation}','InvitationController@destroy');



// Route::get('showUser','User')
