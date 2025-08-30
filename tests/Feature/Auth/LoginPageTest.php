<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;

class LoginPageTest extends TestCase
{
    public function test_login_page_is_accessible(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }
}
