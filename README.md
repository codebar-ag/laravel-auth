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
php artisan vendor:publish --tag="laravel-auth-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-auth-config"
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
