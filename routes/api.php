<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{UserController, TaskController, TaskStatusController};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'user'], function () {
    Route::post('save', [UserController::class, 'save']);
    Route::post('verify', [UserController::class, 'verify']);
    Route::post('invalidate', [UserController::class, 'invalidate']);
    Route::get('/', [UserController::class, 'getUser']);
});

Route::group(['prefix' => 'task'], function () {

//        Route::group(['middleware' => 'auth_task_action'], function() {
        Route::post('/', [TaskController::class, 'save']);
        Route::get('/', [TaskController::class, 'getTasks']);
        Route::delete('/', [TaskController::class, 'delete']);
        Route::group(['prefix' => 'trash'], function () {
            Route::get('/', [TaskController::class, 'getTrash']);
            Route::delete('/', [TaskController::class, 'delete']);
            Route::post('/restore', [TaskController::class, 'restore']);
        });
//    });
    Route::get('/status', [TaskStatusController::class, 'getTaskStatus']);
});
