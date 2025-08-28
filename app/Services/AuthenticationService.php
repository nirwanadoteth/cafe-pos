<?php

namespace App\Services;

use Filament\Facades\Filament;

class AuthenticationService
{
    public static function isUserAuthenticated(): bool
    {
        return Filament::auth()->check() === true;
    }

    public static function redirectToIntended(): \Illuminate\Http\RedirectResponse
    {
        return redirect()->intended(Filament::getUrl());
    }
}
