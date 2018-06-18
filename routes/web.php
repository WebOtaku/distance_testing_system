<?php

// Root Route
Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/workspace');
    }
    else {
        return redirect('/login');
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

Route::put('/tests/{test}', 'TestController@update');

Route::post('/tests', 'TestController@store');

Route::delete('/tests/{test}', 'TestController@destroy');
/* END Test Routes*/


/* START Question Routes */
Route::get('/questions', 'QuestionController@index');

Route::get('/questions/{question}', 'QuestionController@show');

Route::put('/questions/{question}', 'QuestionController@update');

Route::post('/questions', 'QuestionController@store');

Route::delete('/questions/{question}', 'QuestionController@destroy');

Route::delete('/answer-variants/{answerVariant}', 'AnswerVariantController@destroy');
/* END Question Routes*/


/* START Theme Routes */
Route::get('/themes', 'ThemeController@index');

Route::get('/themes/{theme}', 'ThemeController@show');

Route::put('/themes/{theme}', 'ThemeController@update');

Route::post('/themes', 'ThemeController@store');

Route::delete('/themes/{theme}', 'ThemeController@destroy');
/* END Theme Routes*/


/* START Data Routes */
Route::get('/specialities', 'SpecialityController@index');

Route::get('/cicles', 'CicleController@index');

Route::get('/disciplines/{cicle}', 'DisciplineController@show');

Route::get('/users/{user}', 'UserController@show');

Route::get('/students/{user}', 'StudentController@show');

Route::get('/teachers/{user}', 'TeacherController@show');
/* END Data Routes */