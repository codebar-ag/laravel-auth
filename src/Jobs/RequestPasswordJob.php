<?php

namespace CodebarAg\LaravelAuth\Jobs;

use App\Models\User;
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

    protected int $expirationInMinuets;

    public function __construct(
        public string $email
    ) {
        $this->expirationInMinuets = 60;
    }

    public function handle(): void
    {
        $user = User::query()
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
        $user = User::query()
            ->where('email', $this->email)
            ->sole();

        DB::table('password_resets')->where('email', $this->email)->delete();

        $token = hash_hmac('sha256', Str::random(40), config('app.key'));

        DB::table('password_resets')->insert([
            'email' => $this->email,
            'token' => $token,
            'created_at' => now(),
        ]);

        $url = URL::temporarySignedRoute(
            'reset-password',
            now()->addMinutes($this->expirationInMinuets),
            ['token' => $token, 'email' => $user->email]
        );

        $user->notify(new ResetPasswordNotification($user->name, $url, $this->expirationInMinuets));
    }
}
