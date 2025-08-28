<?php

namespace App\Services;

class EnvironmentService
{
    public static function isProduction(): bool
    {
        return app()->isProduction() === true;
    }

    public static function isDebugEnabled(): bool
    {
        return config('app.debug', false) === true;
    }

    public static function isLocal(): bool
    {
        return app()->isLocal();
    }
}
