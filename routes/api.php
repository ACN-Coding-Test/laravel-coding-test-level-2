<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

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

Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('users', 'App\Http\Controllers\ApiController@getAllResource');
    Route::get('users/{id}', 'App\Http\Controllers\ApiController@getResource');
    Route::post('create/project','App\Http\Controllers\ApiController@createProject');
    Route::post('create/task','App\Http\Controllers\ApiController@createTask');
});


//Route::get('users', 'App\Http\Controllers\ApiController@getAllResource');
//Route::get('users/{id}', 'App\Http\Controllers\ApiController@getResource');
Route::post('users','App\Http\Controllers\ApiController@createResource');
Route::post('users/login','App\Http\Controllers\ApiController@login');
Route::put('users/{id}', 'App\Http\Controllers\ApiController@updateResource');
Route::patch('users/{id}', 'App\Http\Controllers\ApiController@updateResourceData');
Route::delete('users/{id}','App\Http\Controllers\ApiController@deleteResource');
Route::get('project/{name}','App\Http\Controllers\ApiController@getAllProjects');
