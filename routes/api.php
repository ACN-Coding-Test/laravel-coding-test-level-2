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


Route::prefix('v1')->group(function () {
    Route::group(['middleware' => ['auth:api']], function () {
        Route::apiResource('users', App\Http\Controllers\UserController::class)->parameters(['users'=>'user_id']);
        Route::apiResource('projects', App\Http\Controllers\ProjectController::class)->parameters(['projects'=>'project_id']);
        Route::apiResource('tasks', App\Http\Controllers\TaskController::class)->parameters(['tasks'=>'task_id']);

    });
    Route::name('login')->post('users/login', [App\Http\Controllers\UserController::class, 'login']);
});