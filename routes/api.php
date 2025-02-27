<?php

use App\Http\Controllers\API\V1\UserController;
use App\Http\Controllers\API\V1\ProjectController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your applicant. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



// 
Route::post('/user/register', [UserController::class, 'create']);
Route::post('/user/login', [UserController::class, 'login']);
Route::prefix('user')->group(function () {

    Route::middleware('auth:api')->group(function () {
        Route::get('/count', [UserController::class, 'getNumberOfUsers']);
    });

});
Route::get('/users', [UserController::class, 'index']);
Route::post('/user/create', [UserController::class, 'create']);
Route::get('/user/{user}/detail', [UserController::class, 'detail']);
Route::post('/user/{user}/update', [UserController::class, 'update']);
Route::post('/user/{user}/delete', [UserController::class, 'delete']);
// Route::get('/users/count', [UserController::class, 'getNumberOfUsers']);

// Project
Route::get('project', [UserController::class, 'index']);
Route::post('/project/create', [ProjectController::class, 'create']);
Route::post('/project/update', [ProjectController::class, 'update']);
