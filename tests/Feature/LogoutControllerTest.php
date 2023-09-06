<?php

use function Pest\Laravel\assertAuthenticated;
use function Pest\Laravel\assertGuest;

test('unauthorized auth.logout', function () {
    $response = $this->post(route('logout'));
    $response->assertRedirect(route('login'));
})->group('auth', 'logout')->skip();

test('authorized auth.logout', function () {
    $user = authenticatedUser();
    assertAuthenticated(null, $user);

    $response = $this->post(route('logout'));

    assertGuest(null, $user);
    $response->assertRedirect(route('frontend.start.index'));
})->group('auth', 'logout')->skip();
