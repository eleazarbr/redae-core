<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Support\Facades\URL;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegisterTest extends DuskTestCase
{
    private const REGISTER_FORM_SELECTOR = '@register-form';

    private const NAME_SELECTOR = '@name';

    private const EMAIL_SELECTOR = '@email';

    private const PASSWORD_SELECTOR = '@password';

    private const PASSWORD_CONFIRMATION_SELECTOR = '@password_confirmation';

    private const SUBMIT_SELECTOR = '@submit';

    private const TEST_NAME = 'Test User';

    private const TEST_PASSWORD = 'Secret123!';

    private string $testEmail;

    protected function setUp(): void
    {
        parent::setUp();

        // Generate unique email for each test
        $this->testEmail = 'test_' . time() . '_' . rand(1000, 9999) . '@example.com';
    }

    public function test_user_can_register_and_verify_email(): void
    {
        $this->browse(function (Browser $browser) {
            // Register a new user
            $this->fillRegistrationForm($browser)
                ->press(self::SUBMIT_SELECTOR)
                ->waitForLocation(route('verification.notice', absolute: false))
                ->assertPathIs(route('verification.notice', absolute: false));

            // Get the user and generate verification URL
            $user = User::where('email', $this->testEmail)->first();
            $this->assertNotNull($user);
            $this->assertNull($user->email_verified_at);

            $verificationUrl = URL::temporarySignedRoute(
                'verification.verify',
                now()->addMinutes(60),
                ['id' => $user->id, 'hash' => sha1($user->email)]
            );

            // Visit the verification URL
            $browser
                ->visit($verificationUrl)
                ->waitForLocation(route('dashboard', absolute: false))
                ->assertPathIs(route('dashboard', absolute: false));

            // Verify that the email is now verified
            $user->refresh();
            $this->assertNotNull($user->email_verified_at);
        });
    }

    public function test_user_can_register_and_mark_email_as_verified_programmatically(): void
    {
        $this->browse(function (Browser $browser) {
            // Register a new user
            $this->fillRegistrationForm($browser)
                ->press(self::SUBMIT_SELECTOR)
                ->waitForLocation(route('verification.notice', absolute: false))
                ->assertPathIs(route('verification.notice', absolute: false));

            // Get the user and verify email programmatically
            $user = User::where('email', $this->testEmail)->first();
            $this->assertNotNull($user);
            $this->assertNull($user->email_verified_at);

            // Mark email as verified programmatically
            $user->markEmailAsVerified();

            // Verify that the email is now verified
            $user->refresh();
            $this->assertNotNull($user->email_verified_at);

            // Navigate to dashboard to confirm access
            $browser
                ->visit(route('dashboard', absolute: false))
                ->waitForLocation(route('dashboard', absolute: false))
                ->assertPathIs(route('dashboard', absolute: false));
        });
    }

    private function fillRegistrationForm(Browser $browser): Browser
    {
        return $browser
            ->visit(route('register'))
            ->waitFor(self::REGISTER_FORM_SELECTOR)
            ->type(self::NAME_SELECTOR, self::TEST_NAME)
            ->type(self::EMAIL_SELECTOR, $this->testEmail)
            ->type(self::PASSWORD_SELECTOR, self::TEST_PASSWORD)
            ->type(self::PASSWORD_CONFIRMATION_SELECTOR, self::TEST_PASSWORD);
    }
}
