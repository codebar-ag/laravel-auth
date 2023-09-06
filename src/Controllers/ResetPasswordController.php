<?php

namespace CodebarAg\LaravelAuth\Controllers;

use App\Models\User;
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
        $reset = DB::table('password_resets')
            ->where('token', $request->validated('token'))
            ->sole();

        if ($reset->email !== $request->validated('email')) {
            throw ValidationException::withMessages([
                'email' => __('Translations'),
            ]);
        }

        $user = User::query()
            ->where('email', $request->validated('email'))
            ->first();

        if (! $user instanceof User) {
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

        DB::table('password_resets')->where('token', $request->validated('token'))->delete();

        session()->regenerate();

        flash(__('passwords.reset'), 'success');

        return redirect()->intended();
    }
}
