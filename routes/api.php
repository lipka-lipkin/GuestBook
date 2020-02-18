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

Route::group(['middleware' => 'throttle:60,1'], function(){

    Route::post('auth/register', 'AuthController@register');
    Route::post('auth/login','AuthController@login');

    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('user/self', 'UserController@self');
        Route::apiResource('posts', 'PostController');
        Route::apiResource('posts.answers', 'AnswerController');
    });

});

Route::post('file', 'FileController@store')->middleware('throttle:5,1');
