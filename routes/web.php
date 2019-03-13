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
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::resource('employee', 'EmployeeController', ['except' => ['show']]);
	Route::get('expert', 'EmployeeController@expertShow')->name('expert.index');
	Route::get('expert/create', 'EmployeeController@createExpert')->name('expert.create');
	// Route::delete('expert/')
	Route::post('expert', 'EmployeeController@storeExpert')->name('expert.store');
	Route::get('employeetemporary', 'EmployeeController@etemporaryShow')->name('employeetemporary.index');
	Route::get('employeetemporary/create', 'EmployeeController@createEtemporary')->name('employeetemporary.create');
	Route::post('employeetemporary', 'EmployeeController@storeEtemporary')->name('employeetemporary.store');
	Route::resource('employeetax', 'TaxController');
	Route::resource('experttax', 'ExpertTaxController');
	Route::resource('etemporarytax', 'EtemporaryTaxController');
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
});

