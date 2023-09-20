<?php

use CodebarAg\LaravelAuth\Notifications\ResetPasswordNotification;
use Illuminate\Support\Facades\Notification;

test('unauthorized auth.request-password.index', function () {
    $response = $this->get(route('auth.request-password'));
    $response->assertOk();
})->group('auth', 'request-password')
    ->skip(fn () => config('laravel-auth.features.password_reset') === false, 'This test is not applicable when password reset is disabled');

test('authorized auth.request-password.index', function () {
    $userModel = config('laravel-auth.model.user');

    $user = $userModel::factory()->create([
        'email_verified_at' => null,
    ]);

    $this->actingAs($user)
        ->get(route('auth.request-password'))
        ->assertRedirect();
})->group('auth', 'request-password')
    ->skip(fn () => config('laravel-auth.features.password_reset') === false, 'This test is not applicable when password reset is disabled');

test('unauthorized auth.request-password.store', function () {
    $userModel = config('laravel-auth.model.user');
    Notification::fake();

    $user = $userModel::factory()->create();

    $this->post(route('auth.request-password.store'), [
        'email' => $user->email,
    ])
        ->assertSessionDoesntHaveErrors()
        ->assertRedirect();

    Notification::assertSentTo($user, ResetPasswordNotification::class);
})->group('auth', 'request-password')
    ->skip(fn () => config('laravel-auth.features.password_reset') === false, 'This test is not applicable when password reset is disabled');

test('authorized auth.request-password.store', function () {
    $userModel = config('laravel-auth.model.user');

    $user = $userModel::factory()->create([
        'email_verified_at' => null,
    ]);

    $this->actingAs($user)
        ->post(route('auth.request-password.store'), [
            'email' => $user->email,
        ])
        ->assertRedirect();
})->group('auth', 'request-password')
    ->skip(fn () => config('laravel-auth.features.password_reset') === false, 'This test is not applicable when password reset is disabled');
