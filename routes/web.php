<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'HomeController@index');

Auth::routes();

//Admin features
Route::group(['middleware' => 'admin', 'prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::get('/', 'HomeController@index'); 
    
    Route::resource('subjects', 'SubjectsController');
});

//User features
Route::group(['namespace' => 'Web', 'middleware' => 'auth'], function () {
    Route::resource('users', 'UsersController', ['only' => [
        'edit', 'destroy', 'update',
    ]]);
});
