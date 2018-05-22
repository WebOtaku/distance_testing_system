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

// Root Route
Route::get('/', 'Controller@index');


/* START Register Routes */
Route::get('/register', 'RegistrationController@create');

Route::post('/register', 'RegistrationController@store');
/* END Register Routes */


/* START Auth Routes */
Route::get('/login', ['as' => 'login', 'uses' => 'SessionController@create']);

Route::post('/login', 'SessionController@store');

Route::get('/logout', 'SessionController@destroy');
/* END Auth Routes*/


/* START Workspace Routes */
Route::get('/workspace/{vue_capture?}', 'WorkspaceController@index')
    ->where('vue_capture', '[\/\w\.-]*')->name('home');
/* END Workspace Routes */


/* START Test Routes */
Route::get('/tests', 'TestController@index');

Route::put('/tests', 'TestController@update');

Route::post('/tests', 'TestController@store');

Route::delete('/tests', 'TestController@destroy');
/* END Test Routes*/


/* START Test Routes */
Route::get('/questions', 'QuestionController@show');

Route::post('/questions', 'QuestionController@store');

Route::delete('/questions', 'QuestionController@destroy');
/* END Test Routes*/


/* START Data Routes */
Route::get('/specialities', 'SpecialityController@index');

Route::get('/user', 'UserController@show');

Route::get('/student', 'StudentController@show');

Route::get('/themes', 'ThemeController@index');
/* END Data Routes */