<?php

namespace Tests\Feature\Controllers\Employees;

it('unauthorized auth.login', function () {
    $response = $this->get(route('login'));
    $response->assertOk();
})->group('auth', 'login')->skip();

it('authorized auth.login', function () {
    authenticatedUser();
    $response = $this->get(route('login'));
    $response->assertRedirect();
})->group('auth', 'login')->skip();

test('authorized customer.auth.login.store', function () {
    $user = authenticatedUser();
    $route = route('login.store');

    $response = $this->post($route, [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertRedirect(route('frontend.start.index'));
})->group('auth', 'login')->skip();
