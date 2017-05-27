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
Route::get('/users/view/{id}', 'UserController@viewUser');
Route::resource("user",'UserController');

Route::get('/admin/data', 'AdminUserController@userList');
Route::resource("admin",'AdminUserController');

Route::get('/sport/data', 'SportsController@sportList');
Route::resource("sport",'SportsController');

Route::get('/subsport/data', 'SubsportsController@subsportList');
Route::resource("subsport",'SubsportsController');

Route::get('/invitation/data', 'InvitationController@invitationList');
Route::resource("invitation",'InvitationController');

Route::get('/team/data', 'TeamController@teamList');
Route::resource("team",'TeamController');

Route::get('/field/data', 'FieldController@fieldList');
Route::get('/field/sportcenter/data', 'FieldController@sportcenterList');

Route::delete('/field/sportcenter/destroy/{id}', 'FieldController@sportcenterDestroy');

Route::get('/sportcenter/active/{id}', 'FieldController@sportcenterPublicStatus');
Route::get('/field/active/{id}', 'FieldController@fieldPublicStatus');

Route::get('/sportcenter/review/{id}', 'FieldController@sportcenterReviewStatus');
Route::get('/field/review/{id}', 'FieldController@fieldReviewStatus');

Route::get('field/{id}/scedit','FieldController@sportcenterEdit');

Route::put('field/scupdate/{id}','FieldController@sportcenterUpdate')->name('field.scupdate');
Route::resource("field",'FieldController');

Route::get('/match/data', 'MatchController@matchList');
Route::resource('match','MatchController');

Route::get('/sportcenter/actives/{id}', 'SportcenterController@sportcenterPublicStatus');
Route::get('/sportcenter/data', 'SportcenterController@sportcenterList');
Route::get('/sportcenter/view/{id}', 'SportcenterController@viewSportCentre');
Route::resource('sportcenter','SportcenterController');

Route::get('/pitch/data', 'PitchController@pitchList');
Route::get('/pitch/active/{id}', 'PitchController@pitchPublicStatus');
Route::resource("pitch",'PitchController');


Route::get("/activity/data",'ActivityController@activityList');
Route::get("/activity/data/page/{nextPageNo}/{perPage}",'ActivityController@getActivities');
Route::resource("activity",'ActivityController');