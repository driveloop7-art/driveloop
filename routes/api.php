<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Api\Controllers\Auth\AuthenticatedSessionController;
use App\Modules\Api\Controllers\Auth\RegisteredUserController;
use App\Modules\Api\Controllers\Auth\LogoutUserController;
use App\Modules\Api\Controllers\Auth\PasswordResetController;
use App\Modules\Api\Controllers\Auth\VerifyEmailController;

Route::middleware('throttle:5,1')->group(function () {
    Route::post('/register', [RegisteredUserController::class, 'register']);
    Route::post('/login', [AuthenticatedSessionController::class, 'login']);
    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink']);
    Route::post('/reset-password', [PasswordResetController::class, 'reset']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthenticatedSessionController::class, 'getUser']);
    Route::post('/logout', [LogoutUserController::class, 'logout']);
    Route::post('/email/verification-notification', [VerifyEmailController::class, 'sendNotification']);
    Route::post('/email/verify', [VerifyEmailController::class, 'verifyNotification']);
});