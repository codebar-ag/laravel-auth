<?php

namespace CodebarAg\LaravelAuth;

use CodebarAg\LaravelAuth\Models\AuthProvider;
use CodebarAg\LaravelAuth\Observers\AuthProviderObserver;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use SocialiteProviders\Manager\SocialiteWasCalled;
use SocialiteProviders\Microsoft\MicrosoftExtendSocialite;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelAuthServiceProvider extends PackageServiceProvider
{
    protected $events = [
        SocialiteWasCalled::class => [
            MicrosoftExtendSocialite::class.'@handle',
        ],
    ];

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-auth')
            ->hasConfigFile('laravel-auth')
            ->hasRoutes('auth')
            ->hasViews()
            ->hasAssets()
            ->hasMigration('create_auth_provider_table')
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishAssets()
                    ->publishMigrations()
                    ->askToRunMigrations();
            });
    }

    public function packageBooted()
    {
        $events = $this->app->make(Dispatcher::class);

        foreach ($this->events as $event => $listeners) {
            foreach ($listeners as $listener) {
                $events->listen($event, $listener);
            }
        }

        AuthProvider::observe(AuthProviderObserver::class);

        VerifyEmail::createUrlUsing(function ($notifiable) {
            return URL::temporarySignedRoute(
                name: 'auth.verification.verify',
                expiration: Carbon::now()->addMinutes(config('laravel-auth.link_expiration_in_minutes', 60)),
                parameters: [
                    'id' => $notifiable->getKey(),
                    'hash' => sha1($notifiable->getEmailForVerification()),
                ]
            );
        });
    }
}
