<?php

namespace CodebarAg\LaravelAuth\Controllers;

use CodebarAg\LaravelAuth\Requests\ResetPasswordRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ResetPasswordController
{
    public function index()
    {
        return view('auth::reset-password')
            ->with([
                'token' => request()->token,
                'email' => request()->email,
            ]);
    }

    public function store(ResetPasswordRequest $request)
    {
        $table = config('laravel-auth.password_reset_table', 'password_reset_tokens');

        $reset = DB::table($table)
            ->where('token', $request->validated('token'))
            ->sole();

        if ($reset->email !== $request->validated('email')) {
            throw ValidationException::withMessages([
                'email' => __('Translations'),
            ]);
        }

        $userModel = config('laravel-auth.model.user');

        $user = $userModel::query()
            ->where('email', $request->validated('email'))
            ->first();

        if (! $user instanceof $userModel) {
            throw ValidationException::withMessages([
                'email' => __('Error'),
            ]);
        }

        $user->update([
            'password' => Hash::make($request->validated('password')),
        ]);

        $credentials = [
            'email' => $request->validated('email'),
            'password' => $request->validated('password'),
        ];

        if (! Auth::attempt($credentials, true)) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        DB::table($table)->where('token', $request->validated('token'))->delete();

        session()->regenerate();

        flash(__('passwords.reset'), 'success');

        return redirect()->intended(
            config('laravel-auth.redirect.password-reset') ?
                route(config('laravel-auth.redirect.password-reset')) :
                '/'
        );
    }
}
