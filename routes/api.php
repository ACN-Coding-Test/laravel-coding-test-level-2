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

Route::name('login')->post('/v1/login', [AuthController::class,'login']);

Route::group(['middleware' => ['auth:api']], function () {
    Route::name('logout')->post('/v1/logout', [AuthController::class,'logout']);
    Route::resource('/v1/users', UserController::class);
    Route::resource('v1/projects', ProjectController::class);
    Route::resource('v1/tasks', TaskController::class);
});

