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


/* Root Route */
Route::get('/', 'Controller@index');
/*--------------------*/


/* Register Routes */
Route::get('/register', 'RegistrationController@create');

Route::post('/register', 'RegistrationController@store');
/*--------------------*/


/* Auth Routes */
Route::get('/login', ['as' => 'login', 'uses' => 'SessionController@create']);

Route::post('/login', 'SessionController@store');

// Logout
Route::get('/logout', 'SessionController@destroy');
/*--------------------*/


/* Workspace Routes */
Route::get('/workspace/{vue_capture?}', 'WorkspaceController@index')
    ->where('vue_capture', '[\/\w\.-]*')->name('home');
/*--------------------*/


/* Data Routes */
Route::get('/specialities', 'SpecialityController@index');

Route::get('/user', 'UserController@show');

Route::get('/student', 'StudentController@show');

Route::get('/tests', 'TestController@index');
/*--------------------*/