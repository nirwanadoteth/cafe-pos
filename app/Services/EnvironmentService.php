<?php

namespace App\Services;

class EnvironmentService
{
    /**
     * Check if the application is running in production environment
     *
     * @return bool True if in production environment
     */
    public static function isProduction(): bool
    {
        return app()->isProduction() === true;
    }

    /**
     * Check if debug mode is enabled
     *
     * @return bool True if debug is enabled
     */
    public static function isDebugEnabled(): bool
    {
        return config('app.debug', false) === true;
    }

    /**
     * Check if the application is running in local environment
     *
     * @return bool True if in local environment
     */
    public static function isLocal(): bool
    {
        return app()->isLocal();
    }
}
