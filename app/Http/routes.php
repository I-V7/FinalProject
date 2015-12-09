<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/', 'PagesController@welcome');
Route::get('info', 'PagesController@info');
Route::get('profile','PagesController@userProfile');
Route::get('home', 'PagesController@home');
Route::get('create', 'TeamController@createTeams');
Route::get('teams', 'TeamController@store');
Route::get('auth/login', 'PagesController@auth');
Route::get('editteams', 'TeamController@edit');
Route::get('viewteams', 'TeamController@show');
Route::get('updatestudentinfo', 'PagesController@updateInfo');

Route::get('updateteams','TeamController@update');
Route::get('update2', 'PagesController@updateInfo2');

Route::controllers([
   'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);