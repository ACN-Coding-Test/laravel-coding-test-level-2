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
Route::post('users/login',[\App\Http\Controllers\UserController::class,'login']);
Route::group(['prefix' => 'users','middleware' => 'auth:sanctum'],function () {
    //user
    Route::get('list', [\App\Http\Controllers\UserController::class,'index']);
    Route::get('view/{id}', [\App\Http\Controllers\UserController::class,'show']);
    Route::post('add', [\App\Http\Controllers\UserController::class,'store']);
    Route::put('update/{id}', [\App\Http\Controllers\UserController::class,'update']);
    Route::delete('remove/{id}', [\App\Http\Controllers\UserController::class,'destroy']);

    //project
    Route::get('project/list', [\App\Http\Controllers\ProjectController::class,'index']);
    Route::get('view-project/{id}', [\App\Http\Controllers\ProjectController::class,'show']);
    Route::post('add-project', [\App\Http\Controllers\ProjectController::class,'store']);
    Route::put('update-project/{id}', [\App\Http\Controllers\ProjectController::class,'update']);
    Route::delete('remove-project/{id}', [\App\Http\Controllers\ProjectController::class,'destroy']);

    //task
    Route::get('task/list', [\App\Http\Controllers\TaskController::class,'index']);
    Route::get('view-task/{id}', [\App\Http\Controllers\TaskController::class,'show']);
    Route::post('add-task', [\App\Http\Controllers\TaskController::class,'store']);
    Route::put('update-task/{id}', [\App\Http\Controllers\TaskController::class,'update']);
    Route::delete('remove-task/{id}', [\App\Http\Controllers\TaskController::class,'destroy']);
    Route::get('teams', [\App\Http\Controllers\TaskController::class,'getTeams']);
    Route::post('assign-task', [\App\Http\Controllers\TaskController::class,'assignTask']);
    Route::post('update-task-status', [\App\Http\Controllers\TaskController::class,'updateStatus']);
});
