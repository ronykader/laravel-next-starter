<?php

use App\Http\Controllers\API\v1\AuthController;
use Illuminate\Support\Facades\Route;

// API routes for version 1
Route::prefix('v1')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});
Route::prefix('v1')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::get('/user', [AuthController::class, 'userDetails']);
        Route::get('/users', [AuthController::class, 'users']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });

