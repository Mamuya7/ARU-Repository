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
Route::get('view_meeting','MeetingsController@index');
Route::post('store_meeting','MeetingsController@store');
Route::post('fetch_entities','MeetingsController@fetch');
Route::get('show_meeting/{meetings}','MeetingsController@show')->name('meeting_details');
Route::post('show_users','UsersController@show');


// Departments
Route::get('AddDepartment', 'DepartmentsController@create')->name('AddDepartment');
Route::post('storeDepartment','DepartmentsController@store');
Route::get('showDepartment', 'DepartmentsController@index')->name('showDepartment');
// Route::delete('deletedepartment/{departments}','DepartmentsController@destroy');
Route::post('editDepartment/{departments}','DepartmentsController@edit');

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

//Roles
Route::get('registerRolesForm','RolesController@create')->name('registerRolesForm');
Route::get('displayRoles','RolesController@index')->name('displayRoles');
Route::post('storeRole', 'RolesController@store');
Route::post('editRole/{roles}','RolesController@edit');




// Route::get('showUser','User')
