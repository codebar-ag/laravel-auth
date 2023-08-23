<?php

namespace CodebarAg\LaravelAuth;

use CodebarAg\LaravelAuth\Commands\LaravelAuthCommand;
use CodebarAg\LaravelAuth\Models\AuthProvider;
use CodebarAg\LaravelAuth\Observers\AuthProviderObserver;
use Illuminate\Contracts\Events\Dispatcher;
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
            ->hasRoute('laravel-auth')
            ->hasViews('laravel-auth')
            ->hasAssets()
            ->hasMigration('create_auth_provider_table')
            ->hasCommand(LaravelAuthCommand::class)
            ->hasInstallCommand(function(InstallCommand $command) {
                $command
                    ->publishAssets()
                    ->publishMigrations();
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
    }
}
