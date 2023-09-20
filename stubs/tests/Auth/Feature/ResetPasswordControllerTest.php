<?php

use App\Models\User;
use Illuminate\Routing\Middleware\ValidateSignature;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

test('unauthorized auth.reset-password.store with valid token', function () {
    $user = User::factory()->create([
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
})->group('auth', 'reset-password');

test('authorized reset-password.store', function () {
    $token = Str::random();

    $user = User::factory()->create([
        'email_verified_at' => null,
    ]);

    $this->actingAs($user)
        ->post(route('auth.reset-password.store', $token))
        ->assertRedirect();
})->group('auth', 'reset-password');
