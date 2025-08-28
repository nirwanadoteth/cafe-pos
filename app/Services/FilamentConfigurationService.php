<?php

namespace App\Services;

use Filament\Facades\Filament;
use Filament\Support\Facades\FilamentColor;

class FilamentConfigurationService
{
    public static function configureCurrentPanelColors(): void
    {
        $panel = Filament::getCurrentOrDefaultPanel();
        if ($panel !== null) {
            FilamentColor::register($panel->getColors());
        }
    }
}
