<?php

// config for CodebarAg/LaravelAuth
use Spatie\Honeypot\ProtectAgainstSpam;

return [
    'middleware' => [
        'web',
        ProtectAgainstSpam::class
    ],
];
