<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\UserRoleController;
use App\Http\Controllers\Api\TaskStatusController;
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
Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);

Route::group(["middleware" => "auth:sanctum"], function($router){
    // User Resources
    Route::get('/v1/users', [UserController::class, 'getAll'])->name('Get All User List');
    Route::get('/v1/users/{user_id}', [UserController::class, 'get'])->name('Get Single User');
    Route::put('/v1/users/{id}', [UserController::class, 'update'])->name('Put Update User');
    Route::patch('/v1/users/{id}', [UserController::class, 'patchupdate'])->name('Patch Update User');
    Route::delete('/v1/users/{id}', [UserController::class, 'delete'])->name('Delete User');

    // Project Resources
    Route::post('/v1/projects', [ProjectController::class, 'create'])->name('Create New Project');
    Route::get('/v1/projects', [ProjectController::class, 'getAll'])->name('Get All Project List');
    Route::get('/v1/projects/{id}', [ProjectController::class, 'get'])->name('Get Single Project');
    Route::put('/v1/projects/{id}', [ProjectController::class, 'update'])->name('Put Update Project');
    Route::patch('/v1/projects/{id}', [ProjectController::class, 'patchupdate'])->name('Patch Update Project');
    Route::delete('/v1/projects/{id}', [ProjectController::class, 'delete'])->name('Delete Project');

    // Task Resources
    Route::post('/v1/tasks', [TaskController::class, 'create'])->name('Create New Task');
    Route::get('/v1/tasks', [TaskController::class, 'getAll'])->name('Get All Task List');
    Route::get('/v1/tasks/{id}', [TaskController::class, 'get'])->name('Get Single Task');
    Route::put('/v1/tasks/{id}', [TaskController::class, 'update'])->name('Put Update Task');
    Route::patch('/v1/tasks/{id}', [TaskController::class, 'patchupdate'])->name('Patch Update Task');
    Route::delete('/v1/tasks/{id}', [TaskController::class, 'delete'])->name('Delete Task');

     // User Role Resources
     Route::post('/v1/roles', [UserRoleController::class, 'create'])->name('Create New  User Role');
     Route::get('/v1/roles', [UserRoleController::class, 'getAll'])->name('Get All Role List');
     Route::get('/v1/roles/{id}', [UserRoleController::class, 'get'])->name('Get Single Role');
     Route::put('/v1/roles/{id}', [UserRoleController::class, 'update'])->name('Put Update Role');
     Route::patch('/v1/roles/{id}', [UserRoleController::class, 'patchupdate'])->name('Patch Update Role');
     Route::delete('/v1/roles/{id}', [UserRoleController::class, 'delete'])->name('Delete Role');

     // Task Status Resources
     Route::post('/v1/status', [TaskStatusController::class, 'create'])->name('Create New  Status');
     Route::get('/v1/status', [TaskStatusController::class, 'getAll'])->name('Get All Status List');
     Route::get('/v1/status/{id}', [TaskStatusController::class, 'get'])->name('Get Single Status');
     Route::put('/v1/status/{id}', [TaskStatusController::class, 'update'])->name('Put Update Status');
     Route::patch('/v1/status/{id}', [TaskStatusController::class, 'patchupdate'])->name('Patch Update Status');
     Route::delete('/v1/status/{id}', [TaskStatusController::class, 'delete'])->name('Delete Status');
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

