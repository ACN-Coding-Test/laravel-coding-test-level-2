<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;

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
    Route::post("registeruser",[UserController::class, 'registerUser']);
    Route::post("login",[UserController::class, 'login']);
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::group(['prefix'=>'v1'], function (){
        Route::get("users/{id?}",[UserController::class, 'getresources']);
        Route::post("users",[UserController::class, 'createresource']);
        Route::put("users/{id}",[UserController::class, 'updateresource']);
        Route::delete("users/{id}",[UserController::class, 'deleteresource']);

        Route::get("projects/{id?}",[ProjectController::class, 'getprojects']);
        Route::post("projects",[ProjectController::class, 'createproject']);
        Route::put("projects/{id}",[ProjectController::class, 'updateproject']);

        Route::get("tasks/{id?}",[TaskController::class, 'getTasks']);
        Route::post("tasks",[TaskController::class, 'createtask']);
        Route::put("tasks/{id}",[TaskController::class, 'updatetask']);
        Route::delete("tasks/{id}",[TaskController::class, 'deletetask']);
    });
});