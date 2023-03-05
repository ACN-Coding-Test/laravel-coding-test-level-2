<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\TaskController;
use App\Http\Controllers\V1\UserController;
use App\Http\Controllers\V1\ProjectController;
use App\Http\Controllers\V1\AuthenticationController;

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

// Route::name('register')->post('/v1/register',[AuthenticationController::class, 'register']);

Route::name('login')->post('/v1/login', [AuthenticationController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::name('users')->get('/v1/users', [UserController::class, 'index']);
    Route::name('users')->get('/v1/users/{id}', [UserController::class, 'show']);
    Route::name('users')->post('/v1/users',[UserController::class, 'store']);
    Route::name('users')->put('/v1/users/{id}',[UserController::class, 'update']);
    Route::name('users')->delete('/v1/users/{id}',[UserController::class, 'destroy']);
    Route::name('users')->patch('/v1/users/{id}',[UserController::class, 'edit']);

    Route::name('projects')->get('/v1/projects', [ProjectController::class, 'index']);
    Route::name('projects')->get('/v1/projects/{id}', [ProjectController::class, 'show']);
    Route::name('projects')->post('/v1/projects',[ProjectController::class, 'store']);
    Route::name('projects')->put('/v1/projects/{id}',[ProjectController::class, 'update']);
    Route::name('projects')->delete('/v1/projects/{id}',[ProjectController::class, 'destroy']);
    Route::name('projects')->patch('/v1/projects/{id}',[ProjectController::class, 'edit']);

    Route::name('tasks')->get('/v1/tasks', [TaskController::class, 'index']);
    Route::name('tasks')->get('/v1/tasks/{id}', [TaskController::class, 'show']);
    Route::name('tasks')->post('/v1/tasks',[TaskController::class, 'store']);
    Route::name('tasks')->put('/v1/tasks/{id}',[TaskController::class, 'update']);
    Route::name('tasks')->delete('/v1/tasks/{id}',[TaskController::class, 'destroy']);
    Route::name('tasks')->patch('/v1/tasks/{id}',[TaskController::class, 'edit']);

    Route::name('logout')->post('/v1/logout', [AuthenticationController::class, 'logout']);
});