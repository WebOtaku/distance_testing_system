<?php

// Root Route
Route::get('/', function () {
    if (!auth()->check()) {
        return view('layouts.index');
    }
    else {
        return redirect('/workspace');
    }
});


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

Route::get('/tests/{test}', 'TestController@show');

Route::put('/tests', 'TestController@update');

Route::post('/tests', 'TestController@store');

Route::delete('/tests', 'TestController@destroy');
/* END Test Routes*/


/* START Question Routes */
Route::get('/questions/{test}', 'QuestionController@show');

Route::post('/questions', 'QuestionController@store');

Route::delete('/questions', 'QuestionController@destroy');
/* END Question Routes*/


/* START Data Routes */
Route::get('/specialities', 'SpecialityController@index');

Route::get('/user', 'UserController@show');

Route::get('/student', 'StudentController@show');

Route::get('/themes', 'ThemeController@index');
/* END Data Routes */