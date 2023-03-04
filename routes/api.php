<?php

use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\API\V1\ProjectController;
use App\Http\Controllers\API\V1\TaskController;
use App\Http\Controllers\API\V1\UserController;
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

Route::post('login', [AuthController::class, 'login']);
Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::post('logout', [AuthController::class, 'logout']);

        // User's routes
        Route::group(['prefix' => 'users', 'middleware' => 'isAdmin'], function() {
            Route::get('/', [UserController::class, 'index']);
            Route::post('/', [UserController::class, 'store']);
            Route::get('/{user}', [UserController::class, 'show']);
            Route::put('/{user}/update', [UserController::class, 'update']);
            Route::delete('/{user}/remove', [UserController::class, 'destroy']);
        });

        // Project's Route
        Route::group(['prefix' => 'projects'], function() {
            Route::get('/', [ProjectController::class, 'index']);

            Route::group(['middleware' => 'isProductOwner'], function() {
                Route::post('/', [ProjectController::class, 'store'])->middleware('');
                Route::put('/{project}/update', [ProjectController::class, 'update']);
                Route::delete('/{project}/remove', [ProjectController::class, 'destroy']);
            });
            Route::get('/{project}', [ProjectController::class, 'show']);
        });

        // Project's Route
        Route::group(['prefix' => 'tasks'], function() {
            Route::get('/', [TaskController::class, 'index']); // List task

            Route::group(['middleware' => 'isProductOwner'], function () {
                Route::post('/', [TaskController::class, 'store']);  // Create task
                Route::delete('/{task}/remove', [TaskController::class, 'destroy']);  // Remove task
            });

            Route::get('/{task}', [TaskController::class, 'show']);  // Show task
            Route::put('/{task}/update', [TaskController::class, 'update']);  // Update task

            Route::post('/{task}/assign/{user}', [TaskController::class, 'assignTask']);
            Route::post('/{task}/update-status', [TaskController::class, 'updateStatus'])->middleware('isTeamMember');
        });
    });

