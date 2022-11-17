<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
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

Route::post('v1/login', [AuthController::class, 'store'])->name('login');
Route::post('v1/register', [AuthController::class, 'register'])->name('register');

Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::prefix('users')->group(function () {
        Route::get('', [UserController::class, 'index'])->middleware('can:view,App\Models\User');
        Route::post('', [UserController::class, 'store'])->middleware('can:create,App\Models\User');
        Route::get('/{user}', [UserController::class, 'show'])->middleware('can:view,user');
        Route::put('/{user}', [UserController::class, 'updateWithPut'])->middleware('can:update,user');
        Route::patch('/{user}', [UserController::class, 'updateWithPatch'])->middleware('can:update,user');
        Route::delete('/{user}', [UserController::class, 'destroy'])->middleware('can:delete,user');
    });

    Route::prefix('projects')->group(function () {
        Route::get('', [ProjectController::class, 'index']);
        Route::post('', [ProjectController::class, 'store']);
        Route::put('/{project}', [ProjectController::class, 'updateWithPut']);
        Route::patch('/{project}', [ProjectController::class, 'updateWithPatch']);
        Route::get('/{project}', [ProjectController::class, 'show']);
        Route::delete('/{project}', [ProjectController::class, 'destroy']);
    });

    Route::get('roles', RoleController::class);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
