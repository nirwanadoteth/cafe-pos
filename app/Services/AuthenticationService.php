<?php

namespace App\Services;

use Filament\Facades\Filament;
use Illuminate\Http\RedirectResponse;
use Livewire\Features\SupportRedirects\Redirector;

class AuthenticationService
{
    /**
     * Check if a user is currently authenticated in Filament
     *
     * @return bool True if user is authenticated
     */
    public static function isUserAuthenticated(): bool
    {
        return Filament::auth()->check();
    }

    /**
     * Redirect to intended URL or default Filament URL
     *
     * @return RedirectResponse|Redirector Redirect response
     */
    public static function redirectToIntended(): RedirectResponse | Redirector
    {
        return redirect()->intended(Filament::getDefaultPanel()->getRedirectUrl());
    }
}
