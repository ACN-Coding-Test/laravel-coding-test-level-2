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

// Public routes
Route::post('/v1/register', [AuthController::class, 'register']);
Route::post('/v1/login', [AuthController::class, 'login']);

// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::resource('/v1/users', UserController::class);
    Route::resource('/v1/projects', ProjectController::class);

    Route::get('/v1/tasks', [TaskController::class, 'index']);
    Route::get('/v1/tasks/{id}', [TaskController::class, 'show']);
    Route::post('/v1/task', [TaskController::class, 'createTask']);
    Route::put('/v1/assignTask/{id}', [TaskController::class, 'assignTask']);
    Route::put('/v1/updateStatus/{id}', [TaskController::class, 'updateStatus']);
    Route::put('/v1/updateTask/{id}', [TaskController::class, 'updateTask']);

    Route::post('/v1/logout', [AuthController::class, 'logout']);
    Route::get('/v1/user', function(Request $request){
        return $request->user();
    });
});
