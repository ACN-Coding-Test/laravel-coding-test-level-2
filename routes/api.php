<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

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

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::name('users')->get('/v1/users', [UserController::class, 'index']);
    Route::name('users')->get('/v1/users/{id}', [UserController::class, 'show']);
    Route::name('users')->post('/v1/users',[UserController::class, 'store']);
    Route::name('users')->put('/v1/users/{id}',[UserController::class, 'update']);
    Route::name('users')->delete('/v1/users/{id}',[UserController::class, 'destroy']);
    Route::name('users')->patch('/v1/users/{id}',[UserController::class, 'edit']);
});
