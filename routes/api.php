<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\User\UserController;
use App\Http\Controllers\Api\V1\Project\ProjectController;
use App\Http\Controllers\Api\V1\Task\TaskController;
use App\Http\Middleware\IsProductOwner;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

# >>> Auth #

Route::get('/', function () {
    return "welcome to api";
});

Route::get('login', [AuthController::class, 'invalidLogin'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
# <<< Auth #


Route::group(['middleware' => ['jwt.verify']], function() {
    Route::prefix('v1')->group(function () {
        # >>> User Route #
        Route::resource('user',UserController::class)->only([
            'index', 'show', 'store', 'destroy'
        ]);
        Route::put('user/{id}', [UserController::class, 'userPut']);
        Route::patch('user/{id}', [UserController::class, 'userUpdate']);

        # >>> Project Route #
        Route::resource('project',ProjectController::class)->only([
            'index', 'show', 'destroy'
        ]);
        Route::post('project', [ProjectController::class, 'store'])->middleware(IsProductOwner::class);
        Route::put('project/{id}', [ProjectController::class, 'projectPut']);
        Route::patch('project/{id}', [ProjectController::class, 'projectUpdate']);
        
        # >>> Task Route #
        Route::resource('task',TaskController::class)->only([
            'index', 'show', 'destroy'
        ]);
        Route::post('task', [TaskController::class, 'store'])->middleware(IsProductOwner::class);
        Route::put('task/{id}', [TaskController::class, 'taskPut']);
        Route::patch('task/{id}', [TaskController::class, 'taskUpdate']);
        

    });


});