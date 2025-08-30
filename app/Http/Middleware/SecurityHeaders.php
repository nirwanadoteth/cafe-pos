<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        /** @var Response $response */
        $response = $next($request);

        // Content Security Policy
        if (! $response->headers->has('Content-Security-Policy')) {
            $csp = $this->buildCsp();
            $response->headers->set('Content-Security-Policy', $csp, false);
        }

        // X-Content-Type-Options
        if (! $response->headers->has('X-Content-Type-Options')) {
            $response->headers->set('X-Content-Type-Options', 'nosniff', false);
        }

        // X-Frame-Options
        if (! $response->headers->has('X-Frame-Options')) {
            $response->headers->set('X-Frame-Options', 'SAMEORIGIN', false);
        }

        // Referrer-Policy
        if (! $response->headers->has('Referrer-Policy')) {
            $response->headers->set('Referrer-Policy', 'no-referrer', false);
        }

        // Permissions-Policy (formerly Feature-Policy)
        if (! $response->headers->has('Permissions-Policy')) {
            $response->headers->set(
                'Permissions-Policy',
                'camera=(), microphone=(), geolocation=(), payment=(), usb=()',
                false
            );
        }

        // HSTS only in production and only for HTTPS requests
        if (app()->isProduction() && $request->isSecure() && ! $response->headers->has('Strict-Transport-Security')) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload', false);
        }

        return $response;
    }

    protected function buildCsp(): string
    {
        $isProd = app()->isProduction();

        $directives = [
            "default-src 'self'",
            "img-src 'self' data: blob:",
            "font-src 'self' data:",
        ];

        if ($isProd) {
            $directives[] = "script-src 'self' 'unsafe-inline'"; // allow inline for Filament/Livewire
            $directives[] = "style-src 'self' 'unsafe-inline'";
            $directives[] = "connect-src 'self'";
        } else {
            // Development: allow Vite HMR and websockets
            $directives[] = "script-src 'self' 'unsafe-inline' 'unsafe-eval' http://localhost:*";
            $directives[] = "style-src 'self' 'unsafe-inline' http://localhost:*";
            $directives[] = "connect-src 'self' ws: http://localhost:*";
        }

        return implode('; ', $directives);
    }
}
