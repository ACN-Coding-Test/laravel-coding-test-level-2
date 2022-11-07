<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TaskController;

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

    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    Route::middleware('auth:sanctum')->group(function () {

        //User
        Route::get('/users', [UserController::class, 'index'])->name('user.index');
        Route::get('/users/{user}', [UserController::class, 'show'])->name('user.show');
        Route::post('/users', [UserController::class, 'store'])->name('user.store');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('user.update');
        Route::patch('/users/update/password/{user}', [UserController::class, 'updatePassword'])->name('user.update.password');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('user.destroy');

        //Project
        Route::get('/projects', [ProjectController::class, 'index'])->name('project.index');
        Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('project.show');
        Route::post('/projects', [ProjectController::class, 'store'])->name('project.store');
        Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('project.update');
        Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('project.destroy');

        //Task
        Route::get('/tasks', [TaskController::class, 'index'])->name('task.index');
        Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('task.show');
        Route::post('/tasks', [TaskController::class, 'store'])->name('task.store');
        Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('task.update');
        Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('task.destroy');
        Route::get('/tasks/by/project/{id}', [TaskController::class, 'taskListByProject'])->name('task.by.project');
        Route::patch('/tasks/update/status/{task}', [TaskController::class, 'updateTaskStatus'])->name('task.update.status');

    });

});
