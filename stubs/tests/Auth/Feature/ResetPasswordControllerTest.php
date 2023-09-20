<?php

use Illuminate\Routing\Middleware\ValidateSignature;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

test('unauthorized auth.reset-password.store with valid token', function () {
    $userModel = config('laravel-auth.model.user');

    $user = $userModel::factory()->create([
        'email_verified_at' => null,
    ]);

    $this->actingAs($user)
        ->post(route('auth.request-password.store'), [
            'email' => $user->email,
        ]);

    $entry = DB::table(config('laravel-auth.password_reset_table'))->get()->first();

    $this->withoutMiddleware([ValidateSignature::class]);

    $password = Str::random();

    $response = $this->post(route('auth.reset-password.store'), [
        'token' => $entry->token,
        'email' => $user->email,
        'password' => $password,
        'password_confirmation' => $password,
    ]);

    $response->assertSessionDoesntHaveErrors();
    $response->assertRedirect();
})->group('auth', 'reset-password')
    ->skip(fn () => config('laravel-auth.features.password_reset') === false, 'This test is not applicable when password reset is disabled');

test('authorized reset-password.store', function () {
    $userModel = config('laravel-auth.model.user');

    $token = Str::random();

    $user = $userModel::factory()->create([
        'email_verified_at' => null,
    ]);

    $this->actingAs($user)
        ->post(route('auth.reset-password.store', $token))
        ->assertRedirect();
})->group('auth', 'reset-password')
    ->skip(fn () => config('laravel-auth.features.password_reset') === false, 'This test is not applicable when password reset is disabled');
