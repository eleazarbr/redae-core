<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;

class AuthFeatureFlagTest extends TestCase
{
    public function test_auth_routes_are_unavailable_when_disabled(): void
    {
        config(['auth.features.auth' => false]);

        $this->get('/login')->assertNotFound();
        $this->get('/register')->assertNotFound();
    }
}
