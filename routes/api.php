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


Route::group(['prefix' => 'v1', 'middleware' => []], function(){
    Route::get('users','App\Http\Controllers\UserController@index');
    Route::get('users/{user_id}','App\Http\Controllers\UserController@show');
    Route::post('users','App\Http\Controllers\UserController@store');
    Route::put('users/{user_id}','App\Http\Controllers\UserController@update');
    Route::patch('users/{user_id}','App\Http\Controllers\UserController@patch');
    Route::delete('users/{user_id}','App\Http\Controllers\UserController@destroy');

    Route::get('tasks','App\Http\Controllers\TaskController@index');
    Route::get('tasks/{task_id}','App\Http\Controllers\TaskController@show');
    Route::post('tasks','App\Http\Controllers\TaskController@store');
    Route::put('tasks/{task_id}','App\Http\Controllers\TaskController@update');
    Route::patch('tasks/{task_id}','App\Http\Controllers\TaskController@patch');
    Route::delete('tasks/{task_id}','App\Http\Controllers\TaskController@destroy');

    Route::get('projects','App\Http\Controllers\ProjectController@index');
    Route::get('projects/{project_id}','App\Http\Controllers\ProjectController@show');
    Route::post('projects','App\Http\Controllers\ProjectController@store');
    Route::put('projects/{project_id}','App\Http\Controllers\ProjectController@update');
    Route::patch('projects/{project_id}','App\Http\Controllers\ProjectController@patch');
    Route::delete('projects/{project_id}','App\Http\Controllers\ProjectController@destroy');
});
