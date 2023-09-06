<img src="https://banners.beyondco.de/Laravel%20Auth.png?theme=light&packageManager=composer+require&packageName=codebar-ag%2Flaravel-auth&pattern=circuitBoard&style=style_1&description=An+opinionated+way+to+authenticate+in+laravel&md=1&showWatermark=0&fontSize=175px&images=document-report">

[![Latest Version on Packagist](https://img.shields.io/packagist/v/codebar-ag/laravel-auth.svg?style=flat-square)](https://packagist.org/packages/codebar-ag/laravel-auth)
[![GitHub-Tests](https://github.com/codebar-ag/laravel-auth/actions/workflows/run-tests.yml/badge.svg?branch=main)](https://github.com/codebar-ag/laravel-auth/actions/workflows/run-tests.yml)
[![GitHub Code Style](https://github.com/codebar-ag/laravel-auth/actions/workflows/fix-php-code-style-issues.yml/badge.svg?branch=main)](https://github.com/codebar-ag/laravel-auth/actions/workflows/fix-php-code-style-issues.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/codebar-ag/laravel-auth.svg?style=flat-square)](https://packagist.org/packages/codebar-ag/laravel-auth)

This package was developed to give you a quick start to authenticate in laravel. It is opinionated and uses the following packages:

## 💡 What is Laravel Auth?

Laravel Auth is an opinionated way to authenticate in laravel.

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
MICROSOFT_REDIRECT_URI="${APP_URL}"/auth/service/microsoft/redirect
MICROSOFT_TENANT_ID=your-tenant-id
```

⚠️ You need to provide a publicly accessible URL for the `MICROSOFT_REDIRECT_URI` environment variable. You can use [expose](https://expose.dev/) or [ngrok](https://ngrok.com/) for local development.

```bash 
APP_URL=https://your-expose-or-ngrok-url.com

# ✅ This is recommended for production as well:
MICROSOFT_REDIRECT_URI="${APP_URL}"/auth/service/microsoft/redirect
```

Add the following trait to your `User` model:

```php
use CodebarAg\LaravelAuth\Traits\HasAuthProviders;
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
                ->append(MenuItem::externalLink('Logout', '/auth/logout'));
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

Note: you can not register routes for `->withAuthenticationRoutes()` or `->withPasswordResetRoutes()` as this will override the changes we made in the `nova.php` config to routes.

```php
    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes();
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

return [
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


# This is my package laravel-auth

[![Latest Version on Packagist](https://img.shields.io/packagist/v/codebar-ag/laravel-auth.svg?style=flat-square)](https://packagist.org/packages/codebar-ag/laravel-auth)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/codebar-ag/laravel-auth/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/codebar-ag/laravel-auth/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/codebar-ag/laravel-auth/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/codebar-ag/laravel-auth/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/codebar-ag/laravel-auth.svg?style=flat-square)](https://packagist.org/packages/codebar-ag/laravel-auth)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/laravel-auth.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/laravel-auth)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require codebar-ag/laravel-auth
```

### Add configuration to `config/services.php`

```php
'microsoft' => [    
  'client_id' => env('MICROSOFT_CLIENT_ID'),  
  'client_secret' => env('MICROSOFT_CLIENT_SECRET'),  
  'redirect' => env('MICROSOFT_REDIRECT_URI') 
],
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="auth-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="auth-config"
```

You can publish the assets with:

```bash
php artisan vendor:publish --tag="auth-assets"
```

This is the contents of the published config file:

```php
return [
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="laravel-auth-views"
```

## Nova Adjustments
Add the user menu for logout to your `NovaServiceProvider` boot method:
```php
class NovaServiceProvider extends CustomNovaServiceProvider
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
                ->append(MenuItem::externalLink('Logout', '/auth/logout'));
        });
```

Next in your `NovaServiceProvider` replace the routes method with the following:

Note: you can not register routes for `->withAuthenticationRoutes()` or `->withPasswordResetRoutes()` as this will cause the package to not work.

```php
    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes();
    }
```

Next in your `nova.php` config add the following:

```php
    'routes' => [
        'login' => 'auth/login',
    ],
```

## Usage

Add the following trait to your `User` model:

```php
use CodebarAg\LaravelAuth\Traits\HasAuthProviders;
```

Visit your nova admin panel and you will be redirected to the login page.

## Email Verification

If you wish to use email verification, you can add the following to your `User` model:

```php
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
```
Then you can use the following middleware to protect your routes:

```php
EnsureEmailIsVerified::redirectTo('auth.verification.notice'),
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Rhys Lees](https://github.com/codebar-ag)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
