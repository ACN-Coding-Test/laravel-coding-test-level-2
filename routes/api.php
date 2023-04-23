<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => 'api'
], function ($router) {
    

    /** User Module*/
    Route::resource('users', UserController::class);

 	/** Project Module*/
    Route::resource('projects', ProjectController::class);

 	/** Task Module*/
    Route::resource('tasks', TaskController::class);
    

    /**
     * Products Module
     */
    // Route::resource('products', ProductsController::class);
    // Route::resource('products', ProductsController::class);
    // Route::get('products/view/all', [ProductsController::class, 'indexAll']);
    // Route::get('products/view/search', [ProductsController::class, 'search']);

});