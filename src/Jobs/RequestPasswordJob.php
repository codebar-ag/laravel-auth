<?php

namespace CodebarAg\LaravelAuth\Jobs;

use CodebarAg\LaravelAuth\Notifications\ResetPasswordNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

use function App\Jobs\Auth\activity;

class RequestPasswordJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        public string $email
    ) {
    }

    public function handle(): void
    {
        $userModel = config('laravel-auth.model.user');

        $user = $userModel::query()
            ->where('email', $this->email)->exists();

        match ($user) {
            true => self::processRequest(),
            default => self::logRequest(),
        };
    }

    protected function logRequest(): void
    {
        activity('failed-password-reset-attempt')
            ->withProperties(['email' => $this->email])
            ->log('successful login');
    }

    protected function processRequest(): void
    {
        $userModel = config('laravel-auth.model.user');

        $user = $userModel::query()
            ->where('email', $this->email)
            ->sole();

        $table = config('laravel-auth.password_reset_table', 'password_resets');

        DB::table($table)->where('email', $this->email)->delete();

        $token = hash_hmac('sha256', Str::random(40), config('app.key'));

        DB::table($table)->insert([
            'email' => $this->email,
            'token' => $token,
            'created_at' => now(),
        ]);

        $url = URL::temporarySignedRoute(
            'auth.reset-password',
            now()->addMinutes(config('laravel-auth.link_expiration_in_minutes', 60)),
            ['token' => $token, 'email' => $user->email]
        );

        $user->notify(new ResetPasswordNotification($user->name, $url, config('laravel-auth.link_expiration_in_minutes', 60)));
    }
}
