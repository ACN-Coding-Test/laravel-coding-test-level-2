<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/users', 'UserController@index');
Route::get('/users/{user}', 'UserController@show');
Route::post('/users', 'UserController@store');
Route::put('/users/{user}', 'UserController@update');
Route::patch('/users/{user}', 'UserController@edit');
Route::delete('/users/{user}', 'UserController@delete');

Route::get('/projects', 'ProjectController@index');
Route::get('/projects/{project}', 'ProjectController@show');
Route::post('/projects', 'ProjectController@store');
Route::put('/projects/{project}', 'ProjectController@update');
Route::patch('/projects/{project}', 'ProjectController@edit');
Route::delete('/projects/{project}', 'ProjectController@delete');

Route::get('/tasks', 'TaskController@index');
Route::get('/tasks/{task}', 'TaskController@show');
Route::post('/tasks', 'TaskController@store');
Route::put('/tasks/{task}', 'TaskController@update');
Route::patch('/tasks/{task}', 'TaskController@edit');
Route::delete('/tasks/{task}', 'TaskController@delete');
