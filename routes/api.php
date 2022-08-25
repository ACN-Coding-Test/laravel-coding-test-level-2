<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProjectController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\TaskController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {    
    return $request->user();
});

Route::post('/v1/user/register', [AuthController::class, 'register']);
Route::post('/v1/user/login', [AuthController::class, 'login']);

Route::apiResource('/v1/project', ProjectController::class)->middleware('auth:api');
Route::apiResource('/v1/users', UserController::class)->middleware('auth:api');
Route::apiResource('/v1/tasks', TaskController::class)->middleware('auth:api');
