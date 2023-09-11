<?php

namespace Tests\Feature\Controllers\Employees;

use App\Models\User;

it('unauthorized auth.login', function () {
    $this->get(route('auth.login'))
        ->assertOk();
})->group('auth', 'login');

it('authorized auth.login', function () {
    $user = User::factory()->create([
        'email_verified_at' => null,
    ]);

    $this->actingAs($user)
        ->get(route('auth.login'))
        ->assertRedirect();
})->group('auth', 'login');

test('authorized customer.auth.login.store', function () {
    $user = User::factory()->create([
        'email_verified_at' => null,
    ]);

    $this->actingAs($user)
        ->post(route('auth.login.store'), [
            'email' => $user->email,
            'password' => 'password',
        ])
        ->assertRedirect();
})->group('auth', 'login');