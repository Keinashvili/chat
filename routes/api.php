<?php

declare(strict_types=1);

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\UserController;
use Illuminate\Support\Facades\Route;


Route::middleware('guest')->group(function () {
    Route::post('/register', [RegisterController::class, '__invoke']);
    Route::post('/login', [LoginController::class, '__invoke']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [UserController::class, '__invoke']);
    Route::post('/logout', [LogoutController::class, '__invoke']);

    require_once __DIR__ . '/chat.php';
    require_once __DIR__ . '/message.php';
});
