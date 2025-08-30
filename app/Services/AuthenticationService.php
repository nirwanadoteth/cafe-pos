<?php

namespace App\Services;

use Filament\Facades\Filament;

class AuthenticationService
{
    /**
     * Check if a user is currently authenticated in Filament
     *
     * @return bool True if user is authenticated
     */
    public static function isUserAuthenticated(): bool
    {
        return Filament::auth()->check() === true;
    }

    /**
     * Redirect to intended URL or default Filament URL
     *
     * @return \Illuminate\Http\RedirectResponse | \Livewire\Features\SupportRedirects\Redirector Redirect response
     */
    public static function redirectToIntended(): \Illuminate\Http\RedirectResponse | \Livewire\Features\SupportRedirects\Redirector
    {
        return redirect()->intended(Filament::getDefaultPanel()->getRedirectUrl());
    }
}
