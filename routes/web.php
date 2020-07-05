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
Route::post('show_meeting/{meetings}','MeetingsController@show')->name('meeting_details');

Route::post('show_users','UsersController@show');