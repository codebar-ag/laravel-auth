<img src="https://banners.beyondco.de/Laravel%20Auth.png?theme=light&packageManager=composer+require&packageName=codebar-ag%2Flaravel-auth&pattern=circuitBoard&style=style_1&description=An+opinionated+way+to+authenticate+in+laravel&md=1&showWatermark=0&fontSize=175px&images=document-report">

[![Latest Version on Packagist](https://img.shields.io/packagist/v/codebar-ag/laravel-auth.svg?style=flat-square)](https://packagist.org/packages/codebar-ag/laravel-auth)
[![GitHub-Tests](https://github.com/codebar-ag/laravel-auth/actions/workflows/run-tests.yml/badge.svg?branch=main)](https://github.com/codebar-ag/laravel-auth/actions/workflows/run-tests.yml)
[![GitHub Code Style](https://github.com/codebar-ag/laravel-auth/actions/workflows/fix-php-code-style-issues.yml/badge.svg?branch=main)](https://github.com/codebar-ag/laravel-auth/actions/workflows/fix-php-code-style-issues.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/codebar-ag/laravel-auth.svg?style=flat-square)](https://packagist.org/packages/codebar-ag/laravel-auth)

This package was developed to give you a quick start to authenticate in laravel. It is opinionated and uses the following packages:

## 💡 What is Laravel Auth?

Laravel Auth is an internal Laravel Nova Authentication replacement to gain more control over authorizing into Laravel Nova.


## 🛠 Requirements

### > = v1.0

- PHP: `^8.2`
- Laravel: `^10.*`
- Microsoft SSO

## ⚙️ Installation

You can install the package via composer:

```bash
composer require codebar-ag/laravel-auth
```

Add the following script to your `composer.json` file:

```json
"scripts": {
    "post-update-cmd": [
      "@php artisan vendor:publish --tag=auth-assets --ansi --force"
    ],
}
```

Add configuration to your `config/services.php` file: 

```php
'microsoft' => [
    'client_id' => env('MICROSOFT_CLIENT_ID'),
    'client_secret' => env('MICROSOFT_CLIENT_SECRET'),
    'redirect' => env('MICROSOFT_REDIRECT_URI'),
    'tenant' => env('MICROSOFT_TENANT_ID'),
    'include_tenant_info' => true,
],
```

Add the following environment variables to your `.env` file:

```bash
MICROSOFT_CLIENT_ID=your-client-id
MICROSOFT_CLIENT_SECRET=your-client-secret
MICROSOFT_REDIRECT_URI="${APP_URL}/auth/service/microsoft/redirect"
MICROSOFT_TENANT_ID=your-tenant-id
```

⚠️ You need to provide a publicly accessible URL for the `MICROSOFT_REDIRECT_URI` environment variable. You can use [expose](https://expose.dev/) or [ngrok](https://ngrok.com/) for local development.

```bash 
APP_URL=https://your-expose-or-ngrok-url.com

# ✅ This is recommended for production as well:
MICROSOFT_REDIRECT_URI="${APP_URL}/auth/service/microsoft/redirect"
```

Add the following trait to your `User` model:

```php
use CodebarAg\LaravelAuth\Traits\HasAuthProviders;
```

Update your `App\Http\Middleware\Authenticate` middleware:

```diff
...
protected function redirectTo(Request $request): ?string
{
-    return $request->expectsJson() ? null : route('login');
+   return $request->expectsJson() ? null : route('auth.login');
}

```

Finally, run the following command:

```bash
php artisan auth:install
```

## 🚏 Routes

Below are the following routes provided by this package:

| Method      | URI                                   | Name                        | Middleware |
|-------------|---------------------------------------|-----------------------------|------------|
| GET \| HEAD | /auth/login                           | auth.login                  | web        |
| POST        | /auth/login/store                     | auth.login.store            | web        |
| ANY         | /auth/logout                          | auth.logout                 | web        |
| GET \| HEAD | /auth/password                        | auth.request-password       | web        |
| POST        | /auth/password/store                  | auth.request-password.store | web        |
| POST        | /auth/password/reset                  | auth.reset-password         | web        |
| GET \| HEAD | /auth/password/token/{token}          | auth.reset-password.store   | web        |
| GET \| HEAD | /auth/service/{service}               | auth.provider               | web        |
| GET \| HEAD | /auth/service/{service}/redirect      | auth.provider.redirect      | web        |
| GET \| HEAD | /auth/email/verify                    | auth.verification.notice    | web        |
| GET \| HEAD | /auth/email/verify/{id}/{hash}        | auth.verification.verify    | web        |
| POST        | /auth/email/verification-notification | auth.verification.send      | web        |

## 🪐 Nova Adjustments
Add the user menu for logout to your `NovaServiceProvider` boot method:
```php
use Illuminate\Http\Request;
use Laravel\Nova\Menu\Menu;
use Laravel\Nova\Menu\MenuItem;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Nova::userMenu(function (Request $request, Menu $menu) {
            return $menu
                ->append(MenuItem::externalLink('Logout', route('auth.logout')));
        });
```

Next in your `nova.php` config add the following:

```php
/*
|--------------------------------------------------------------------------
| Nova Routes
|--------------------------------------------------------------------------
|
| These are the routes that are used by Nova to authenticate users.
|
*/

'routes' => [
    'login' => 'auth/login',
],
```

Next in your `NovaServiceProvider` replace the routes method with the following:

Note: you can `not` register routes for `->withAuthenticationRoutes()` or `->withPasswordResetRoutes()` as this will override the changes we made in the `nova.php` config to routes.

```diff
    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
-        Nova::routes()
-            ->withAuthenticationRoutes()
-            ->withPasswordResetRoutes();
+        Nova::routes();
    }
```

## 🔧 Configuration file

You can publish the config file with:

```bash
php artisan vendor:publish --tag=auth-config
```

This is the contents of the published config file:

```php
<?php

// config for CodebarAg/LaravelAuth

use CodebarAg\LaravelAuth\Enums\ProviderEnum;

return [
    /*
    |--------------------------------------------------------------------------
    | Redirect Settings
    |--------------------------------------------------------------------------
    | You may like to define a different route once the user is
    | logged in or out. If no redirects are defined, the package will redirect to the
    | intended route. (This is the normal Laravel behaviour)
    |
    | Use the route name as defined in your routes file.
    |
    | If password-reset is not defined, the package will redirect to the login redirect route.
    |
    */
    'redirect' => [
        // 'login' => 'dashboard',
        // 'logout' => '',
        // 'password-reset' => '',
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Logo Settings
    |--------------------------------------------------------------------------
    | You may like to define a different logo for the login page.
    | The path is relative to the public folder.
    |
    */
    'logo' => [
        'path' => 'vendor/auth/images/lock.svg',
    ],

    /*
    |--------------------------------------------------------------------------
    | Middleware Settings
    |--------------------------------------------------------------------------
    | By default, the package will use the web middleware group.
    | You may define them the same way you would in your routes file.
    |
    */
    'middleware' => [
        //
    ],

    /*
    |--------------------------------------------------------------------------
    | Link  Settings
    |--------------------------------------------------------------------------
    | By default, the package will use 60 minutes as the expiration time for
    | the signed links used in the email verification process.
    | You may define a different value here.
    |
    */
    'link_expiration_in_minutes' => 60,

    /*
    |--------------------------------------------------------------------------
    | Toast Settings
    |--------------------------------------------------------------------------
    | By default, the package will use 5000 milliseconds as the time to fade
    | out the toast messages.
    | You may define a different value here.
    |
    */
    'toast_fade_time_in_milliseconds' => 5000,
    
    /*
    |--------------------------------------------------------------------------
    | Password Reset Settings
    |--------------------------------------------------------------------------
    | By default, the package will use the password_resets table.
    | You may define a different table name here.
    |
    */
    'password_reset_table' => 'password_resets',
    
    /*
    |--------------------------------------------------------------------------
    | Provider Settings
    |--------------------------------------------------------------------------
    | By default, all providers are enabled.
    | You may disable a provider by adding it to the disabled array.
    |
    */
    'providers' => [
        'disabled' => [
            // ProviderEnum::MICROSOFT_OFFICE_365(),
        ],
    ]
];
```

## 🔐 Verify

If you wish to use email verification, you can add the following to your `User` model:

```php
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
```

Then you can use the following middleware to protect your routes:

```php
Illuminate\Auth\Middleware\EnsureEmailIsVerified::redirectTo('auth.verification.notice'),
```

You use verification in nova, add the middleware into in your `nova.php` config:

```php
/*
|--------------------------------------------------------------------------
| Nova Route Middleware
|--------------------------------------------------------------------------
|
| These middleware will be assigned to every Nova route, giving you the
| chance to add your own middleware to this stack or override any of
| the existing middleware. Or, you can just stick with this stack.
|
*/

'middleware' => [
    'web',
    EnsureEmailIsVerified::redirectTo('auth.verification.notice'),
    HandleInertiaRequests::class,
    DispatchServingNovaEvent::class,
    BootTools::class,
],
```

## 🎨 Customisation

You can publish the assets using:

```bash
php artisan vendor:publish --tag=auth-assets
```

You can publish the config using:

```bash
php artisan vendor:publish --tag=auth-config
```

You can publish the migrations using:

```bash
php artisan vendor:publish --tag=auth-migrations
```

You can publish the translations using:

```bash
php artisan vendor:publish --tag=auth-translations
```

This package uses [Laravel Honeypot](https://github.com/spatie/laravel-honeypot) to prevent spam.Check out the [documentation](https://github.com/spatie/laravel-honeypot#readme) to learn how to customise it.

```bash

You can publish the views using:

```bash
php artisan vendor:publish --tag=auth-views
```

## 🚧 Testing

Copy your own phpunit.xml-file.

```bash
cp phpunit.xml.dist phpunit.xml
```

Run the tests:

```bash
./vendor/bin/pest
```

## 📝 Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## ✏️ Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## 🧑‍💻 Security Vulnerabilities

Please review [our security policy](.github/SECURITY.md) on how to report security vulnerabilities.

## 🙏 Credits

- [Rhys Lees](https://github.com/RhysLees)
- [All Contributors](../../contributors)
- [Skeleton Repository from Spatie](https://github.com/spatie/package-skeleton-laravel)
- [Laravel Package Training from Spatie](https://spatie.be/videos/laravel-package-training)

## 🎭 License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
