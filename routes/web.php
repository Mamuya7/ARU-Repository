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
Route::post('fetch_meeting_members','MeetingsController@fetch');
Route::post('show_meeting/{meeting}','MeetingsController@show');

Route::post('show_users','UsersController@show');



Route::get('AddDepartment', 'DepartmentsController@create')->name('AddDepartment');
Route::post('storeDepartment','DepartmentsController@store');
Route::get('showDepartment', 'DepartmentsController@show')->name('ShowDepartment');
Route::delete('deletedepartment/{departments}','DepartmentsController@destroy');
Route::post('editDepartment/{departments}','DepartmentsController@edit');


Route::get('showschools','SchoolsController@index')->name('showschools');
Route::get('AddSchool', 'SchoolsController@create')->name('AddSchool');
Route::post('storeschools', 'SchoolsController@store');
Route::delete('deleteschool/{schools}','SchoolsController@destroy');
Route::post('editSchool/{schools}','SchoolsController@edit');


// Route::get('showUser','User')
