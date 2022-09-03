<?php

use App\Http\Controllers\Api\AuthController;
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

    Route::post('login', [AuthController::class,'login'])->name('login');

    Route::group(['middleware'=>'auth:sanctum'], function (){
        Route::post('logout', [AuthController::class,'logout'])->name('logout');
        Route::resource('users', UserController::class,['except'=>['index','show']]);
        Route::patch('users/{user}/roles/reassign',[UserController::class,'update']);
        Route::resource('projects', ProjectController::class,['except'=>['index','show']]);
        Route::patch('projects/{project}/transfer',[ProjectController::class, 'update']);
        Route::resource('tasks', TaskController::class,['except'=>['index','show']]);
        Route::patch('tasks/{task}/transfer',[TaskController::class, 'update']);
        Route::patch('tasks/{task}/change-status',[TaskController::class, 'update']);
    });

    Route::resource('users', UserController::class,['only'=>['index','show']]);
    Route::resource('projects', ProjectController::class,['only'=>['index','show']]);
    Route::resource('tasks', TaskController::class,['only'=>['index','show']]);

    Route::get('unauthorized', function () {
        return response()->json(['message' => 'Unauthorized.'], 401);
    })->name('unauthorized');
});
