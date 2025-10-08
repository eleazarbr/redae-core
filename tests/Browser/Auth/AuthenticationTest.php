<?php

namespace Tests\Browser\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\LoginPage;
use Tests\DuskTestCase;

class AuthenticationTest extends DuskTestCase
{
    private const TEST_PASSWORD = 'Secret123!';

    public function test_user_can_log_in(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make(self::TEST_PASSWORD),
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $page = new LoginPage;

            $browser->visit($page)
                ->on($page);

            $page->fillForm($browser, [
                'email' => $user->email,
                'password' => self::TEST_PASSWORD,
            ]);

            $page->submit($browser)
                ->waitForLocation(route('dashboard', absolute: false))
                ->assertPathIs(route('dashboard', absolute: false));
        });
    }
}
