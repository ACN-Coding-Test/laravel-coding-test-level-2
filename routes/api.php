<?php
use App\Http\Controllers\APIController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;

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


Route::group(
  ['prefix' => 'v1'],
  function(){
      //public route
     Route::post('/register', [AuthController::class,'register']);
     Route::post('/login', [AuthController::class,'login']);

    Route::resource('users', UserController::class)->missing(function (Request $request) {
        return Redirect::route('photos.index');
    });
    // Route::get('/users/search/{username}', [UserController::class,'Search']);

    Route::resource('projects', ProjectController::class);
    Route::resource('tasks', TaskController::class);
      //protected routes
    Route::group(['middleware' => ['auth:sanctum']], function () {
        // Route::get('/users/search/{username}', [UserController::class,'Search']);
        Route::post('/logout', [AuthController::class,'logout']);

    });
  }

);
