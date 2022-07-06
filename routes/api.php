<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
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

//AUTH
Route::post('/v1/register-admin', [AuthController::class, 'registerAdmin']);

//USER
Route::get('/v1/users', [UserController::class, 'getAllUser']);
Route::post('/v1/users', [UserController::class, 'addUser']);
Route::get('/v1/users/{id}', [UserController::class, 'getUser']);
Route::put('/v1/users/{id}', [UserController::class, 'putUser']);
Route::patch('/v1/users/{id}', [UserController::class, 'patchUser']);
Route::delete('/v1/users/{id}', [UserController::class, 'deleteUser']);

//PROJECT
Route::post('/v1/projects', [ProjectController::class, 'addProject']);
Route::get('/v1/projects', [ProjectController::class, 'getAllProject']);
Route::get('/v1/projects/{id}', [ProjectController::class, 'getProject']);
Route::delete('/v1/projects/{id}', [ProjectController::class, 'deleteProject']);

//TASK
Route::post('/v1/tasks', [TaskController::class, 'addTask']);
Route::get('/v1/tasks', [TaskController::class, 'getAllTask']);
Route::get('/v1/tasks/{id}', [TaskController::class, 'getTask']);
Route::delete('/v1/tasks/{id}', [TaskController::class, 'deleteTask']);
Route::post('/v1/tasks/update', [TaskController::class, 'updateStatusTask']);