<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\AdminAccess;


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



Route::group([
    'prefix' => 'v1',
    'middleware' => ['auth:api']
], function () {
    Route::middleware([AdminAccess::class])->group(function(){
        Route::apiResource('users', UsersController::class);
    });
    Route::apiResource('project', ProjectController::class);
    Route::apiResource('task', TaskController::class);
});

Route::post('v1/login', [AuthController::class,'login'])->name('login');



