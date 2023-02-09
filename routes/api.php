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

// api/V1/users
// Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1'], function()
// {
//   Route::apiResource('users', UserController::class);
//   Route::apiResource('tasks', TaskController::class);
//   Route::apiResource('projects', ProjectController::class);
// });

Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1'], function () {

    /* User routes */
    Route::any('users',      'UserController@index');
    Route::any('showUser/{id}', 'UserController@showUser');
    Route::any('updateUser/{id}', 'UserController@updateUser');
    Route::any('deleteUser/{id}', 'UserController@deleteUser');
    Route::any('createUser', 'UserController@createUser');

    /* Task routes */
    Route::any('tasks',      'TaskController@index');
    Route::any('showTask/{id}', 'TaskController@showTask');
    Route::any('updateTask/{id}', 'TaskController@updateTask');
    Route::any('deleteTask/{id}', 'TaskController@deleteTask');
    Route::any('createTask', 'TaskController@createTask');

    /* Project routes */
    Route::any('projects',      'ProjectController@index');
    Route::any('showProject/{id}', 'ProjectController@showProject');
    Route::any('updateProject/{id}', 'ProjectController@updateProject');
    Route::any('deleteProject/{id}', 'ProjectController@deleteProject');
    Route::any('createProject', 'ProjectController@createProject');
  });
  
