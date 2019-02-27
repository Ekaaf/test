<?php

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
    return view('welcome');
});

Route::get('/login', array('as' => 'login', 'uses' => 'LoginController@login'));
Route::post('postLogin', array('as' => 'postLogin', 'uses' => 'LoginController@postLogin'));
Route::get('/logout', array('as' => 'logout', 'uses' => 'LoginController@logout'));

Route::group(['middleware' => 'admin'], function() {
    Route::get('dashboard', 'LoginController@dashboard');
	Route::post('downloadFile', 'LoginController@downloadFile');
});
