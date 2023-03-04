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


/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::group(['prefix'=>'v1'], function (){
    Route::get("users/{id?}",[UserController::class, 'getresources']);
    Route::post("users",[UserController::class, 'createresource']);
    Route::put("users/{id}",[UserController::class, 'updateresource']);
    Route::delete("users/{id}",[UserController::class, 'deleteresource']);

    Route::get("projects/{id?}",[ProjectController::class, 'getprojects']);
    Route::post("projects",[ProjectController::class, 'createproject']);
    Route::put("projects/{id}",[ProjectController::class, 'updateproject']);
    Route::delete("projects/{id}",[ProjectController::class, 'deleteproject']);

    Route::get("tasks/{id?}",[TaskController::class, 'getTasks']);
    Route::post("tasks",[TaskController::class, 'createtask']);
    Route::put("tasks/{id}",[TaskController::class, 'updatetask']);
    Route::delete("tasks/{id}",[TaskController::class, 'deletetask']);

});


