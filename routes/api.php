<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/signup', 'JwtController@signUp');

Route::post('/signin', 'JwtController@signIn');

Route::group(['middleware' => 'jwt.auth'], function () {
    Route::get('/restricted', 'JwtController@restricted');

    Route::group(['prefix' => 'acl', 'namespace' => 'Acl'], function () {
        Route::resource('roles', 'RoleController');
    });
});