<?php
use App\Http\Controllers\V1\UserController;
use App\Http\Controllers\V1\ProjectController;
use App\Http\Controllers\V1\TaskController;
use Illuminate\Support\Facades\Route;

Route::namespace('V1/users')
    ->prefix('v1/users')
    ->as('user.')
    ->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/{user}', [Usercontroller::class, 'show'])->name('show');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::patch('/{user}', [UserController::class, 'update']);
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('delete');
    });

Route::namespace('V1/project')
    ->prefix('v1/project')
    ->as('projects.')
    ->group(function(){
        Route::get('/', [ProjectController::class, 'index'])->name('index');
        Route::get('/{project}', [ProjectController::class, 'show'])->name('show');
        Route::post('/', [ProjectController::class, 'store'])->name('store');
        Route::put('/{project}',[ProjectController::class, 'update'])->name('update');
        Route::patch('/{project}',[ProjectController::class, 'update'])->name('update');
        Route::delete('/{project}', [ProjectController::class, 'destroy'])->name('delete');
    });

Route::namespace('V1/task')
    ->prefix('v1/task')
    ->as('task.')
    ->group(function(){
        Route::get('/', [TaskController::class, 'index'])->name('index');
        Route::get('/{task}', [TaskController::class, 'show'])->name('show');
        Route::post('/', [TaskController::class, 'store'])->name('store');
        Route::put('/{task}',[TaskController::class, 'update'])->name('update');
        Route::patch('/{task}',[TaskController::class, 'update'])->name('update');
        Route::delete('/{task}', [TaskController::class, 'destroy'])->name('delete');
    });