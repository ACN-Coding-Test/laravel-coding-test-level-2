<?php

use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\API\V1\UserController;
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

Route::post('login', [AuthController::class, 'login']);
Route::group(['middleware' => 'auth:sanctum'],
    function () {
        Route::post('logout', [AuthController::class, 'logout']);

        // User's routes
        Route::group(['prefix' => 'users', 'middleware' => 'isAdmin'], function() {
            Route::get('/', [UserController::class, 'index']);
            Route::post('/', [UserController::class, 'store']);
            Route::get('/{user}', [UserController::class, 'show']);
            Route::put('/{user}/update', [UserController::class, 'update']);
            Route::delete('/{user}/remove', [UserController::class, 'destroy']);
        });
    });

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
