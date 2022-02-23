<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\LoginController;

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

Route::group(
    ['prefix' => 'v1'],
    function () {
        Route::post('/login', [LoginController::class, 'login']);
        Route::group(
            ['middleware' => 'auth:sanctum'],
            function () {
                Route::resource('users', UserController::class);
                Route::resource('projects', ProjectController::class);
                Route::resource('tasks', TaskController::class);
            }
        );
    }
);

