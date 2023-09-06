<?php

use CodebarAg\LaravelAuth\Notifications\ResetPasswordNotification;
use Illuminate\Support\Facades\Notification;

test('unauthorized auth.request-password.index', function () {
    $response = $this->get(route('request-password'));
    $response->assertOk();
})->group('auth', 'request-password')->skip();

test('authorized auth.request-password.index', function () {

    authenticatedUser();
    $response = $this->get(route('request-password'));
    $response->assertRedirect(route('frontend.start.index'));
})->group('auth', 'request-password')->skip();

test('unauthorized auth.request-password.store', function () {
    Notification::fake();

    $user = user();

    $response = $this->post(route('request-password.store'), [
        'email' => $user->email,
    ]);

    $response->assertSessionDoesntHaveErrors();
    $response->assertRedirect(route('request-password'));

    Notification::assertSentTo($user, ResetPasswordNotification::class);
})->group('auth', 'request-password')->skip();

test('authorized auth.request-password.store', function () {
    authenticatedUser();
    $response = $this->post(route('request-password.store'));
    $response->assertRedirect(route('frontend.start.index'));
})->group('auth', 'request-password')->skip();
