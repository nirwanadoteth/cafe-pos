<?php

namespace App\Filament\Pages;

use App\Services\AuthenticationService;
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
        if (AuthenticationService::isUserAuthenticated()) {
            AuthenticationService::redirectToIntended();
        }
    }

    public function getMaxWidth(): Width | string | null
    {
        return Width::ScreenLarge;
    }

    public function getTitle(): string | Htmlable
    {
        return __('pages/welcome.title');
    }

    public function getHeading(): string | Htmlable
    {
        return __('pages/welcome.heading');
    }

    public function hasLogo(): bool
    {
        return false;
    }
}
