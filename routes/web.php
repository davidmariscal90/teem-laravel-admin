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

Auth::routes();

Route::get('/', 'HomeController@index');

Route::get('/home', 'HomeController@index');

//user
Route::get('/users/data', 'UserController@userList');
Route::resource("user",'UserController');

Route::get('/admin/data', 'AdminUserController@userList');
Route::resource("admin",'AdminUserController');