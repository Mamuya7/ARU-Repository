<?php

use Illuminate\Support\Facades\Route;

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

Route::get('create_meeting','MeetingsController@create');
Route::get('view_meeting','MeetingsController@index')->name('view_meetings');
Route::post('store_meeting','MeetingsController@store');
Route::post('fetch_meeting_members','MeetingsController@fetch');
Route::post('show_meeting/{meeting}','MeetingsController@show');
Route::post('uploadfile/{meeting}','MeetingsController@uploadFile');
Route::post('downloadfile','MeetingsController@downloadFile');

Route::post('show_users','UsersController@show');


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
