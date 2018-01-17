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


Route::post('register', 'Auth\RegisterController@register');
Route::post('login', 'Auth\LoginController@login');

    Route::post('upload', 'UserController@postImage');
    Route::get('fetchData', 'UserController@fetchData');

	Route::group(['middleware' => 'jwt.auth'], function () {
    Route::post('user', 'UserController@getAuthUser');
});
