<?php

use Illuminate\Routing\Middleware\ValidateSignature;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

test('unauthorized auth.reset-password.store with valid token', function () {
    $user = user();

    $this->post(route('request-password.store'), [
        'email' => $user->email,
    ]);

    $entry = DB::table('password_resets')->get()->first();

    $this->withoutMiddleware([ValidateSignature::class]);

    $password = Str::random();

    $response = $this->post(route('reset-password.store'), [
        'token' => $entry->token,
        'email' => $user->email,
        'password' => $password,
        'password_confirmation' => $password,
    ]);

    $response->assertSessionDoesntHaveErrors();
    $response->assertRedirect(route('frontend.start.index'));
})->group('auth', 'reset-password')->skip();

test('authorized reset-password.store', function () {
    $token = Str::random();
    authenticatedUser();
    $response = $this->post(route('reset-password.store', $token));
    $response->assertRedirect(route('frontend.start.index'));
})->group('auth', 'reset-password')->skip();
