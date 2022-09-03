<?php

use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\UserController;
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

Route::group(['prefix'=>'v1'], function (){
    Route::resource('users', UserController::class,['except'=>'edit']);
    Route::patch('users/{user}/roles/reassign', [UserController::class,'update'])->name('users.roles.reassign');
    Route::resource('projects', ProjectController::class,['except'=>'edit']);
    Route::patch('projects/{project}/users/{user}/reassign', [ProjectController::class,'update'])->name('projects.users.reassign');
    Route::resource('tasks', TaskController::class,['except'=>'edit']);
    Route::patch('tasks/{task}/users/{user}/reassign', [ProjectController::class,'update'])->name('tasks.users.reassign');
});
