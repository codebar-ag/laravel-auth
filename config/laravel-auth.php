<?php

// config for CodebarAg/LaravelAuth

return [
    'logo' => [
        'path' => 'vendor/auth/images/lock.svg',
    ],

    'middleware' => [
        'web',
    ],

    'link_expiration_in_minutes' => 60,
    'toast_fade_time_in_milliseconds' => 5000,
];
