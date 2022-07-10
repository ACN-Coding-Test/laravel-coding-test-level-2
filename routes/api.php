<?php
use App\Http\Controllers\Api\v1\UserController;
use App\Http\Controllers\Api\v1\ProjectController;
use App\Http\Controllers\Api\v1\TaskController;
use App\Http\Controllers\Api\v1\ProjectUserController;
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

Route::get("v1/users",[UserController::class,'index']);
Route::get("v1/users/{id}",[UserController::class,'show']);
Route::post("v1/users",[UserController::class,'create']);
Route::put("v1/users/{id}",[UserController::class,'update']);
Route::patch("v1/users/{id}",[UserController::class,'patch']);
Route::delete("v1/users/{id}",[UserController::class,'destroy']);

Route::get("v1/projects",[ProjectController::class,'index']);
Route::get("v1/projects/{id}",[ProjectController::class,'show']);
Route::post("v1/projects",[ProjectController::class,'create']);
Route::put("v1/projects/{id}",[ProjectController::class,'update']);
Route::patch("v1/projects/{id}",[ProjectController::class,'patch']);
Route::delete("v1/projects/{id}",[ProjectController::class,'destroy']);

Route::get("v1/projectuser",[ProjectUserController::class,'index']);
Route::get("v1/projectuser/{id}",[ProjectUserController::class,'show']);
Route::post("v1/projectuser",[ProjectUserController::class,'create']);
Route::put("v1/projectuser/{id}",[ProjectUserController::class,'update']);
Route::patch("v1/projectuser/{id}",[ProjectUserController::class,'patch']);
Route::delete("v1/projectuser/{id}",[ProjectUserController::class,'destroy']);

Route::get("v1/tasks",[TaskController::class,'index']);
Route::get("v1/tasks/{id}",[TaskController::class,'show']);
Route::post("v1/tasks",[TaskController::class,'create']);
Route::put("v1/tasks/{id}",[TaskController::class,'update']);
Route::patch("v1/tasks/{id}",[TaskController::class,'patch']);
Route::delete("v1/tasks/{id}",[TaskController::class,'destroy']);
//Route::apiResource('users', 'Api\v1\users')->only(['index','show']);
