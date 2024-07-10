<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

// 一般 User
Route::prefix('/user')
    ->group(function () {
        Route::post('/login', [UserController::class, 'login']);

        Route::middleware('auth:user')
            ->group(function () {
                Route::get('/me', [UserController::class, 'me']);
            });
    });



// --------------------------------------------------------------------------
// Admin
Route::prefix('/admin')
    ->group(function () {
        Route::post('/login', [AdminController::class, 'login']);

        Route::middleware('auth:admin')
            ->group(function () {
                Route::get('/me', [AdminController::class, 'me']);
            });
    });

