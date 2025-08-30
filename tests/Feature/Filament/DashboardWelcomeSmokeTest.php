<?php

declare(strict_types=1);

namespace Tests\Feature\Filament;

use App\Models\User;
use Tests\TestCase;

class DashboardWelcomeSmokeTest extends TestCase
{
    public function test_welcome_page_renders_for_guest(): void
    {
        $response = $this->get('/');
        $response->assertOk();
        $response->assertSee('Welcome to CafePOS');
        $response->assertHeader('Content-Security-Policy');
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('Referrer-Policy', 'no-referrer');
        $response->assertHeader('Permissions-Policy');
    }

    public function test_guest_is_redirected_to_login_when_visiting_dashboard(): void
    {
        $response = $this->followingRedirects()->get('/dashboard');
        $response->assertOk();
        $response->assertHeader('Content-Security-Policy');
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('Referrer-Policy', 'no-referrer');
        $response->assertHeader('Permissions-Policy');
    }

    public function test_dashboard_renders_for_authenticated_user(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($user)->get('/dashboard');
        $response->assertOk();
        $response->assertHeader('Content-Security-Policy');
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('Referrer-Policy', 'no-referrer');
        $response->assertHeader('Permissions-Policy');
    }
}
