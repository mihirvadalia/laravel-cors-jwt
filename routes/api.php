<?php

use Illuminate\Http\Request;

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

Route::get('/restricted', 'JwtController@restricted')->middleware('jwt.auth');

Route::group(['domain' => 'api.jwt.dev', 'prefix' => 'v1'], function () {
   Route::get('/restricted', 'JwtController@crossDomainRestricted');
});
