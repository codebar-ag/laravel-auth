<?php

use App\Models\User;
use CodebarAg\LaravelAuth\Notifications\ResetPasswordNotification;
use Illuminate\Support\Facades\Notification;

test('unauthorized auth.request-password.index', function () {
    $response = $this->get(route('auth.request-password'));
    $response->assertOk();
})->group('auth', 'request-password');

test('authorized auth.request-password.index', function () {
    $user = User::factory()->create([
        'email_verified_at' => null,
    ]);

    $this->actingAs($user)
        ->get(route('auth.request-password'))
        ->assertRedirect();
})->group('auth', 'request-password');

test('unauthorized auth.request-password.store', function () {
    Notification::fake();

    $user = User::factory()->create();

    $this->post(route('auth.request-password.store'), [
            'email' => $user->email,
        ])
        ->assertSessionDoesntHaveErrors()
        ->assertRedirect();

    Notification::assertSentTo($user, ResetPasswordNotification::class);
})->group('auth', 'request-password');

test('authorized auth.request-password.store', function () {
    $user = User::factory()->create([
        'email_verified_at' => null,
    ]);

    $this->actingAs($user)
        ->post(route('auth.request-password.store'), [
            'email' => $user->email,
        ])
        ->assertRedirect();
})->group('auth', 'request-password');
