<?php

use function Pest\Laravel\assertAuthenticated;
use function Pest\Laravel\assertGuest;

test('unauthorized auth.logout', function () {
    $this->post(route('auth.logout'))
        ->assertRedirect();
})->group('auth', 'logout');

test('authorized auth.logout', function () {
    $userModel = config('laravel-auth.model.user');

    $user = $userModel::factory()->create([
        'email_verified_at' => null,
    ]);

    Auth::login($user);

    assertAuthenticated(null, $user);

    $this->post(route('auth.logout'))
        ->assertRedirect();

    assertGuest(null, $user);
})->group('auth', 'logout');
