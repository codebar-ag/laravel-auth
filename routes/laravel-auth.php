<?php

use CodebarAg\LaravelAuth\Controllers\AuthLoginController;
use CodebarAg\LaravelAuth\Controllers\AuthLogoutController;
use CodebarAg\LaravelAuth\Controllers\ProviderController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->middleware(config('laravel-auth.middleware', []))->group(function () {
    Route::get('login', AuthLoginController::class)->name('auth.login');
    Route::get('logout', AuthLogoutController::class)->name('auth.logout');

    Route::get('{service}', [ProviderController::class, 'service'])->name('auth.provider');

    Route::get('{service}/redirect', [ProviderController::class, 'serviceRedirect']);
});
