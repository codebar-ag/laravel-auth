<?php

namespace Tests\Feature\Controllers\Employees;

use function Pest\Laravel\assertAuthenticated;

it('unauthorized auth.login', function () {
    $this->get(route('auth.login'))
        ->assertOk();
})->group('auth', 'login');

it('authorized auth.login', function () {
    $userModel = config('laravel-auth.model.user');

    $user = $userModel::factory()->create([
        'email_verified_at' => null,
    ]);

    $this->actingAs($user)
        ->get(route('auth.login'))
        ->assertRedirect();

})->group('auth', 'login');

test('authorized customer.auth.login.store', function () {
    $userModel = config('laravel-auth.model.user');

    $user = $userModel::factory()->create([
        'email_verified_at' => null,
    ]);

    $this->actingAs($user)
        ->post(route('auth.login.store'), [
            'email' => $user->email,
            'password' => 'password',
        ])
        ->assertRedirect();

    assertAuthenticated(null, $user);
})->group('auth', 'login')
    ->skip(fn () => config('laravel-auth.features.basic') === false, 'This test is not applicable when basic auth is disabled');
