<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;

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

Route::middleware('auth:sanctum')
->get('/userlogin', function (Request $request) {
    return $request->user();
});

// Route::post('/tokens/create', function (Request $request) {
//     $token = $request->user()->createToken($request->token_name);
 
//     return ['token' => $token->plainTextToken];
// });


Route::group(['middleware' => 'auth:sanctum'],
    function () {
        Route::get('/user', [UsersController::class, 'getUsers']);
        Route::get('/user/{id}', [UsersController::class, 'getUserById']);
        Route::post('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/user', [UsersController::class, 'storeUser']);
        // Route::get('/user', [UsersController::class, 'getUsers'])->middleware('auth:sanctum');

        Route::put('/user/{id}', [UsersController::class, 'updateUser']);
        Route::patch('/user/{id}', [UsersController::class, 'updateUser']);
        Route::delete('/user/{id}', [UsersController::class, 'deleteUser']);

        Route::post('/project', [ProjectController::class, 'storeProject']);
        Route::get('/project', [ProjectController::class, 'getProjects']);
        Route::get('/project/{id}', [ProjectController::class, 'getProjectById']);
        Route::patch('/project/{id}', [ProjectController::class, 'updateProject']);
        Route::delete('/project/{id}', [ProjectController::class, 'deleteProject']);

        Route::post('/task', [TaskController::class, 'storeTask']);
        Route::get('/task', [TaskController::class, 'getTasks']);
        Route::patch('/task/status/{id}', [TaskController::class, 'updateStatus']);
        Route::get('/task/{id}', [TaskController::class, 'getTaskById']);
        Route::patch('/task/{id}', [TaskController::class, 'updateTask']);

Route::delete('/task/{id}', [TaskController::class, 'deleteTask']);
    });

Route::post('/login', [AuthController::class, 'login']);


