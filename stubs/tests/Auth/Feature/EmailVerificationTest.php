<?php

use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;

test('email verification screen can be rendered', function () {
    $userModel = config('laravel-auth.model.user');

    $user = $userModel::factory()->create([
        'email_verified_at' => null,
    ]);

    $this->actingAs($user)
        ->get(route('auth.verification.notice'))
        ->assertOk();
})->group('auth', 'verify-email')
    ->skip(fn () => config('laravel-auth.features.email_verification') === false, 'This test is not applicable when email verification is disabled');

test('email can be verified', function () {
    $userModel = config('laravel-auth.model.user');
    Event::fake();

    $user = $userModel::factory()->create([
        'email_verified_at' => null,
    ]);

    $verificationUrl = URL::temporarySignedRoute(
        'auth.verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1($user->email)]
    );

    $this->actingAs($user)
        ->get($verificationUrl)
        ->assertRedirect();

    Event::assertDispatched(Verified::class);

    expect($user->fresh()->hasVerifiedEmail())->toBeTrue();
})->group('auth', 'verify-email')
    ->skip(fn () => config('laravel-auth.features.email_verification') === false, 'This test is not applicable when email verification is disabled');

test('email can not verified with invalid hash', function () {
    $userModel = config('laravel-auth.model.user');

    $user = $userModel::factory()->create([
        'email_verified_at' => null,
    ]);

    $verificationUrl = URL::temporarySignedRoute(
        'auth.verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1('wrong-email')]
    );

    $this->actingAs($user)
        ->get($verificationUrl);

    expect($user->fresh()->hasVerifiedEmail())->toBeFalse();
})->group('auth', 'verify-email')
    ->skip(fn () => config('laravel-auth.features.email_verification') === false, 'This test is not applicable when email verification is disabled');
