<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::controller(MainController::class)->group(function(){

    Route::get('login', 'index')->name('login');

    Route::get('registration', 'registration')->name('registration');

    Route::get('logout', 'logout')->name('logout');

    Route::post('validate_registration', 'validate_registration')->name('main.validate_registration');

    Route::post('validate_login', 'validate_login')->name('main.validate_login');

    Route::get('dashboard', 'dashboard')->name('dashboard');

    Route::get('logout', 'logout')->name('logout');

});

Route::controller(ProjectController::class)->group(function(){
    Route::get('createProject', 'index')->name('createProject');
    Route::get('projectDetails/{id}', 'projectDetails')->name('projectDetails');
    Route::post('submit', 'create')->name('submit');
    Route::post('changeStatus', 'changeStatus')->name('changeStatus');
});

Route::controller(TaskController::class)->group(function(){
    Route::any('createTask', 'index')->name('createTask');
    Route::any('edit', 'edit')->name('edit');
    Route::post('submitTask', 'create')->name('submitTask');
    Route::post('updateTask', 'update')->name('updateTask');
});