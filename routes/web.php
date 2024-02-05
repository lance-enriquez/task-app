<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\{HomeController, TrashController, LoginController, RegistrationController};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['prefix' => '/'], function () {
    Route::get('/', function() {return view('login');});
    Route::post('/', [LoginController::class, 'login']);
    Route::any('logout', [HomeController::class, 'logout']);
});

Route::group(['prefix' => 'register'], function () {
    Route::get('/', function () {return view('register');});
    Route::post('/', [RegistrationController::class, 'register']);
});

Route::group(['middleware' => 'session_checker'], function () {
    Route::get('/home', function () {return view('home');});
    Route::get('/trash', function () {return view('trash');});

    Route::group(['prefix' => 'task'], function () {
        Route::get('/', [HomeController::class, 'getTask']);
        Route::post('/', [HomeController::class, 'saveTask']);
        Route::delete('/', [HomeController::class, 'delete']);
        Route::post('/status', [HomeController::class, 'updateTaskStatus']);
        Route::group(['prefix' => 'trash'], function () {
            Route::get('/', [TrashController::class, 'getTrash']);
            Route::post('/', [TrashController::class, 'restoreTrash']);
            Route::delete('/', [HomeController::class, 'delete']);
        });
    });
});

Route::get('task/status', [HomeController::class, 'getTaskStatus']);
