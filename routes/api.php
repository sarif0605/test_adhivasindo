<?php

use App\Http\Controllers\API\AuthAPIController;
use App\Http\Controllers\API\ContentAPIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('content-three', [ContentAPIController::class, 'showThreeContent']);
    Route::get('content', [ContentAPIController::class, 'index']);
    Route::get('content/{id}', [ContentAPIController::class, 'show']);
    Route::post('content', [ContentAPIController::class, 'store'])->middleware('auth:api');
    Route::put('content/{id}', [ContentAPIController::class, 'update'])->middleware('auth:api');
    Route::delete('content/{id}', [ContentAPIController::class, 'destroy'])->middleware('auth:api');
    Route::get('dashboard', [ContentAPIController::class, 'dashboard'])->middleware('auth:api');
    Route::prefix('auth')->group(function () {
        Route::post('register', [AuthAPIController::class, 'register']);
        Route::post('login', [AuthAPIController::class, 'login']);
        Route::post('logout', [AuthAPIController::class, 'logout'])->middleware('auth:api');
    });
});
