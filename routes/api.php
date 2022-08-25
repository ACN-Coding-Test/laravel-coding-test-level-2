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

Route::prefix('v1')->group(function () {
    Route::apiResource('users', App\Http\Controllers\UserController::class)->parameters(['users'=>'user_id']);
    Route::apiResource('projects', App\Http\Controllers\ProjectController::class)->parameters(['projects'=>'project_id']);
    Route::apiResource('tasks', App\Http\Controllers\TaskController::class)->parameters(['tasks'=>'task_id']);
});