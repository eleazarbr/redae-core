<?php

namespace Tests\Feature;

use Tests\TestCase;

class WelcomePageTest extends TestCase
{
    public function test_root_renders_the_welcome_page(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertViewHas('page', function (array $page): bool {
                return ($page['component'] ?? null) === 'Welcome';
            });
    }
}
