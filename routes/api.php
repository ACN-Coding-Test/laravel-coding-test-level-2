<?php

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(
    ['namespace' => 'Api', 'middleware' => 'auth:sanctum', 'as' => 'api.'],
    function () {
        Route::group(
            ['prefix' => 'v1'],
            function () {
                Route::group(
                    ['prefix' => 'users'],
                    function () {
                        Route::get('/', [App\Http\Controllers\UserController::class, 'getUsers'])->name('get.users');
                        Route::get('/{user_id}', [App\Http\Controllers\UserController::class, 'getUser'])->name('get.user');
                        Route::post('/', [App\Http\Controllers\UserController::class, 'createUser'])->name('create.user');
                        Route::put('/{user_id}', [App\Http\Controllers\UserController::class, 'updateUser'])->name('update.user');
                        // PUT and PATCH method almost same
                        Route::patch('/{user_id}', [App\Http\Controllers\UserController::class, 'updateUser'])->name('update.user');
                        Route::delete('/{user_id}', [App\Http\Controllers\UserController::class, 'deleteUser'])->name('delete.user');
                    }
                );
            }
        );
    }
);

Route::post('/v1/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');
