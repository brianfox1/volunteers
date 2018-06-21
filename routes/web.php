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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/*User login By*/
Route::get('/user_login_by_id/{user_id}', ['as' => 'user_login_by_id', 'uses' => 'HomeController@user_login_by_id']);

/* Users */
Route::get('/users', ['as' => 'users', 'uses' => 'UserController@index']);
Route::post('/users', ['as' => 'users', 'uses' => 'UserController@index']);
Route::post('/save_user', ['as' => 'save_user', 'uses' => 'UserController@save_user']);
Route::post('/check_user', ['as' => 'check_user', 'uses' => 'UserController@check_user']);

/** Projects */
Route::get('/projects', ['as' => 'projects', 'uses' => 'ProjectController@index']);
Route::post('/projects', ['as' => 'projects', 'uses' => 'ProjectController@index']);
Route::post('/save_project', ['as' => 'save_project', 'uses' => 'ProjectController@save_project']);

/** Teams */
Route::get('/teams', ['as' => 'teams', 'uses' => 'TeamsController@index']);
Route::post('/teams', ['as' => 'teams', 'uses' => 'TeamsController@index']);
