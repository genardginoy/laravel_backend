<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1', 'namespace'=>'App\Http\Controllers\TestControllers'], function() {
    Route::resource('user', 'UserController', [ 'except' => ['edit', 'create'] ]);

    Route::resource('user/{user_id}/todo', 'TodoController', [ 'except' => ['edit', 'create'] ]);
    Route::resource('todo/{td_id}/comment', 'CommentController', [ 'except' => ['edit', 'create'] ]);

    Route::post('test_file', 'TestFileController@processFileInput')->name('testfile.processfileinput');
    Route::post('test_soap', 'TestSoapController@processSoapRequest')->name('testsoap.processsoaprequest');
});

Route::group(['prefix' => 'v2', 'namespace'=>'App\Http\Controllers\AuthControllers'], function() {
    Route::resource('user', 'UserController', [ 'except' => ['edit', 'create'] ]);

    Route::resource('user/{user_id}/todo', 'TodoController', [ 'except' => ['edit', 'create'] ]);
    Route::resource('todo/{td_id}/comment', 'CommentController', [ 'except' => ['edit', 'create'] ]);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'v2',
    'namespace'=>'App\Http\Controllers\AuthControllers'
], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::post('payload', 'AuthController@payload');

});
