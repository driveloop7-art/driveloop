<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Api\Controllers\Auth\AuthenticatedSessionController;
use App\Modules\Api\Controllers\Auth\RegisteredUserController;
use App\Modules\Api\Controllers\Auth\LogoutUserController;
use App\Modules\Api\Controllers\Auth\PasswordResetController;
use App\Modules\Api\Controllers\Auth\VerifyEmailController;
use App\Modules\Api\Controllers\Admin\UserController;
use App\Modules\Api\Controllers\Admin\VehiculosController;
use App\Modules\Api\Controllers\Admin\ReservasController;
use App\Modules\Api\Controllers\Users\DocumentController;
use App\Modules\Api\Controllers\Users\GetUserController;
use App\Modules\Api\Controllers\Auth\PasswordUpdateController;
use App\Modules\Api\Controllers\Users\UpdateEmailController;
use App\Modules\Api\Controllers\Users\ResendEmailVerificationController;
use App\Modules\Api\Controllers\Users\UpdatePhoneNumberController;
use App\Modules\Api\Controllers\Users\DeleteAccountController;

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
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/vehicles', [VehiculosController::class, 'index']);
    Route::get('/reservas', [ReservasController::class, 'index']);

    // Rutas de Documentos del Usuario
    Route::get('/user/documents/types', [DocumentController::class, 'getDocumentTypes']);
    Route::get('/user/documents', [DocumentController::class, 'index']);
    Route::post('/user/documents/upload', [DocumentController::class, 'upload']);
    Route::get('/info-user', [GetUserController::class, 'index']);
    Route::put('/update-password', [PasswordUpdateController::class, 'update']);
    Route::get('/info-user', GetUserController::class);
    Route::put('/user/email', UpdateEmailController::class);
    Route::post('/user/email/resend', ResendEmailVerificationController::class);
    Route::put('user/phone', UpdatePhoneNumberController::class);
    Route::post('/user/delete', DeleteAccountController::class);
});