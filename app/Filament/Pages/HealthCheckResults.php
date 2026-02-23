<?php

namespace App\Filament\Pages;

use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Illuminate\Contracts\Support\Htmlable;
use ShuvroRoy\FilamentSpatieLaravelHealth\Pages\HealthCheckResults as BaseHealthCheckResults;

class HealthCheckResults extends BaseHealthCheckResults
{
    use HasPageShield;

    protected static function getPagePermission(): ?string
    {
        return 'page_HealthCheckResults';
    }

    public static function getNavigationSort(): ?int
    {
        return 5;
    }

    public static function getNavigationLabel(): string
    {
        return 'Monitoring';
    }
}
