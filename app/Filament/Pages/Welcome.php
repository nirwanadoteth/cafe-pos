<?php

namespace App\Filament\Pages;

use Filament\Pages\SimplePage;
use Filament\Support\Enums\Width;
use Filament\Tables\Table\Concerns\HasHeaderActions;
use Illuminate\Contracts\Support\Htmlable;

class Welcome extends SimplePage
{
    use HasHeaderActions;

    protected string $view = 'filament.pages.welcome';

    public function mount(): void
    {
        if (\App\Services\AuthenticationService::isUserAuthenticated()) {
            \App\Services\AuthenticationService::redirectToIntended();
        }
    }

    public function getMaxWidth(): Width | string | null
    {
        return Width::ScreenLarge;
    }

    public function getTitle(): string | Htmlable
    {
        return 'Welcome';
    }

    public function getHeading(): string | Htmlable
    {
        return 'Welcome to CafePOS';
    }

    public function hasLogo(): bool
    {
        return false;
    }
}
