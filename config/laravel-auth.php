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
