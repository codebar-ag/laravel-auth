<?php

use CodebarAg\LaravelAuth\Controllers\EmailVerificationController;
use CodebarAg\LaravelAuth\Controllers\LoginController;
use CodebarAg\LaravelAuth\Controllers\LogoutController;
use CodebarAg\LaravelAuth\Controllers\ProviderController;
use CodebarAg\LaravelAuth\Controllers\RequestPasswordController;
use CodebarAg\LaravelAuth\Controllers\ResetPasswordController;
use Illuminate\Support\Facades\Route;
use Spatie\Honeypot\ProtectAgainstSpam;

Route::prefix('auth')->name('auth.')->middleware(['web'])->group(function () {
    Route::middleware(['guest'])->group(function () {
        Route::prefix('login')->group(function () {
            Route::get('/')->uses([LoginController::class, 'index'])
                ->name('login');

            Route::post('/store')->uses([LoginController::class, 'store'])
                ->middleware(ProtectAgainstSpam::class)
                ->name('login.store');
        });

        Route::prefix('password')->group(function () {
            Route::get('/')->uses([RequestPasswordController::class, 'index'])
                ->name('request-password');

            Route::post('store')->uses([RequestPasswordController::class, 'store'])
                ->name('request-password.store')
                ->middleware(ProtectAgainstSpam::class);

            Route::get('token/{token}')->uses([ResetPasswordController::class, 'index'])
                ->name('reset-password')
                ->middleware('signed');

            Route::post('reset')->uses([ResetPasswordController::class, 'store'])
                ->name('reset-password.store')
                ->middleware(ProtectAgainstSpam::class);
        });

        Route::prefix('service')->group(function () {
            Route::get('{service}', [ProviderController::class, 'service'])->name('provider');
            Route::get('{service}/redirect', [ProviderController::class, 'serviceRedirect'])->name('provider.redirect');
        });
    });

    Route::middleware(['auth'])->group(function () {
        Route::any('logout')->uses(LogoutController::class)
            ->name('logout');

        Route::prefix('email')->group(function () {
            Route::get('verify')->uses([EmailVerificationController::class, 'index'])
                ->name('verification.notice');

            Route::get('verify/{id}/{hash}')->uses([EmailVerificationController::class, 'store'])
                ->middleware(['signed'])->name('verification.verify');

            Route::post('verification-notification')->uses([EmailVerificationController::class, 'send'])
                ->name('verification.send');
        });
    });
});
