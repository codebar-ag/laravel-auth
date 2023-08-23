<?php

namespace CodebarAg\LaravelAuth\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self MICROSOFT_OFFICE_365()
 */
class ProviderEnum extends Enum
{
    protected static function values(): array
    {
        return [
            'MICROSOFT_OFFICE_365' => 'microsoft',
        ];
    }
}
