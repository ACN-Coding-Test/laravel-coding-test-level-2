<?php
use App\Http\Controllers\V1\UserController;
use App\Http\Controllers\V1\ProjectController;
use App\Http\Controllers\V1\TaskController;
use App\Http\Controllers\V1\RoleController;
use App\Http\Controllers\V1\AbilityController;
use Illuminate\Support\Facades\Route;

Route::namespace('V1/users')
    ->prefix('v1/users')
    ->as('user.')
    ->middleware(['admin_api', 'auth:api'])
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
    ->middleware(['product_owner', 'auth:api'])
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
    ->middleware(['auth:api','product_owner'])
    ->group(function(){
        Route::get('/', [TaskController::class, 'index'])->name('index');
        Route::get('/{task}', [TaskController::class, 'show'])->name('show')->withoutMiddleware('team_member');
        Route::post('/', [TaskController::class, 'store'])->name('store');
        Route::put('/{task}',[TaskController::class, 'update'])->name('update')->withoutMiddleware('product_owner');
        Route::patch('/{task}',[TaskController::class, 'update'])->name('update');
        Route::delete('/{task}', [TaskController::class, 'destroy'])->name('delete');
    });
/* For checking role team member */
Route::namespace('V1/task')
    ->prefix('v1/task')
    ->as('task.')
    ->middleware(['auth:api'])
    ->group(function(){
        Route::get('/{task}', [TaskController::class, 'show'])->name('show')->withoutMiddleware('product_owner');
        Route::put('/{task}',[TaskController::class, 'update'])->name('update')->withoutMiddleware('product_owner');
    });

Route::namespace('V1/role')
    ->prefix('v1/role')
    ->as('role.')
    ->middleware('auth:api')
    ->group(function(){
        Route::get('/', [RoleController::class, 'index'])->name('index');
        Route::get('/{role}', [RoleController::class, 'show'])->name('show');
        Route::post('/', [RoleController::class, 'store'])->name('store');
        Route::put('/{role}',[RoleController::class, 'update'])->name('update');
        Route::put('/assign/{user}',[RoleController::class, 'assignRole'])->name('assignRole');
        Route::patch('/{role}',[RoleController::class, 'update'])->name('update');
        Route::delete('/{role}', [RoleController::class, 'destroy'])->name('delete');
    });