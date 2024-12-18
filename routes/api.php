<?php

use Illuminate\Support\Facades\Route;

// Route untuk register dan login user
Route::post('/users', [\App\Http\Controllers\UserController::class, 'register']);
Route::post('/users/login', [\App\Http\Controllers\UserController::class, 'login']);

// Route dengan middleware untuk user authenticatio
Route::middleware(\App\Http\Middleware\ApiAuthMiddleware::class)->group(function () {
    // User
    Route::get('/users/current', [\App\Http\Controllers\UserController::class, 'get']);
    Route::patch('/users/current', [\App\Http\Controllers\UserController::class, 'update']);
    Route::delete('/users/logout', [\App\Http\Controllers\UserController::class, 'logout']);
    // Product
    Route::post('/products', [\App\Http\Controllers\ProductController::class, 'create']);
    Route::get('/products/{id}', [\App\Http\Controllers\ProductController::class, 'get'])->where('id', '[0-9]+');
    Route::put('/products/{id}', [\App\Http\Controllers\ProductController::class, 'update'])->where('id', '[0-9]+');
    Route::delete('/products/{id}', [\App\Http\Controllers\ProductController::class, 'delete'])->where('id', '[0-9]+');
    // Orders
    Route::post('/orders', [\App\Http\Controllers\OrderController::class, 'create'])->where('id', '[0-9]+');
    Route::get('/orders/{id}', [\App\Http\Controllers\OrderController::class, 'get'])->where('id', '[0-9]+');
    Route::get('/orders', [\App\Http\Controllers\OrderController::class, 'getAll']);
});
