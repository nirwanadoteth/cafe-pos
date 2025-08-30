<?php

declare(strict_types=1);

namespace Tests\Feature\Security;

use App\Filament\Resources\Products\ProductResource;
use App\Models\User;
use Tests\TestCase;

class SecurityHeadersTest extends TestCase
{
    public function test_security_headers_are_present_on_root(): void
    {
        $response = $this->get('/');

        $response->assertHeader('Content-Security-Policy');
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('Referrer-Policy', 'no-referrer');
        $response->assertHeader('Permissions-Policy');
    }

    public function test_security_headers_on_authenticated_filament_page(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $this->actingAs($user);

        // Unverified would be blocked by Filament; verified can reach dashboard
        $response = $this->get(ProductResource::getUrl('index'));

        $response->assertHeader('Content-Security-Policy');
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('Referrer-Policy', 'no-referrer');
        $response->assertHeader('Permissions-Policy');
    }

    public function test_hsts_is_present_in_production_over_https(): void
    {
        $previous = $_ENV['APP_ENV'] ?? null;
        // Force production for this test and reboot the app so app()->isProduction() is true
        putenv('APP_ENV=production');
        $_ENV['APP_ENV'] = 'production';
        $_SERVER['APP_ENV'] = 'production';
        $this->refreshApplication();

        try {
            // Simulate HTTPS via trusted proxy header
            $response = $this->withHeader('X-Forwarded-Proto', 'https')->get('/');
            $response->assertHeader('Strict-Transport-Security');
            $this->assertStringContainsString('max-age=31536000', (string) $response->headers->get('Strict-Transport-Security'));
        } finally {
            // Restore previous environment and reboot the app
            if ($previous !== null) {
                putenv('APP_ENV=' . $previous);
                $_ENV['APP_ENV'] = $previous;
                $_SERVER['APP_ENV'] = $previous;
            } else {
                putenv('APP_ENV');
                unset($_ENV['APP_ENV'], $_SERVER['APP_ENV']);
            }
            $this->refreshApplication();
        }
    }
}
