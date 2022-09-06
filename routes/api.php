<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\ProjectController;
use App\Http\Controllers\Api\V1\TaskController;
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

Route::name('login')->post('/v1/login', [AuthController::class,'login']);


Route::group(['middleware' => ['auth:api']], function () {
    Route::name('logout')->post('/v1/logout', [AuthController::class,'logout']);
});

Route::group(['middleware' => ['auth:api','accountRole:admin']], function () {
    Route::resource('/v1/users', UserController::class);
});

Route::group(['middleware' => ['auth:api','accountRole:product_owner']], function () {
    Route::resource('v1/projects', ProjectController::class);
    Route::resource('v1/tasks', TaskController::class);
});

Route::group(['middleware' => ['auth:api','accountRole:team_member']], function () {
    Route::put('v1/tasks', [TaskController::class,'update']);
});
