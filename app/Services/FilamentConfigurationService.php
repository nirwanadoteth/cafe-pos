<?php

namespace App\Services;

use Filament\Facades\Filament;
use Filament\Support\Facades\FilamentColor;

class FilamentConfigurationService
{
    /**
     * Configure colors for the current Filament panel
     *
     * Registers the panel's color configuration with FilamentColor facade
     */
    public static function configureCurrentPanelColors(): void
    {
        $panel = Filament::getCurrentOrDefaultPanel();
        if ($panel !== null) {
            FilamentColor::register($panel->getColors());
        }
    }
}
