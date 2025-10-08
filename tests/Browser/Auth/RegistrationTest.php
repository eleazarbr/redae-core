<?php

namespace Tests\Browser\Auth;

use App\Enums\Company\UserRole;
use App\Enums\Company\UserStatus;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\URL;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\RegisterPage;
use Tests\DuskTestCase;

class RegistrationTest extends DuskTestCase
{
    private const TEST_COMPANY_NAME = 'Test Company';

    private const TEST_NAME = 'Test User';

    private const TEST_EMAIL = 'test@example.com';

    private const TEST_PASSWORD = 'Secret123!';

    public function test_user_can_register_and_verify_email(): void
    {
        $this->browse(function (Browser $browser) {
            $page = new RegisterPage;

            $browser->visit($page)
                ->on($page);

            // Register a new user.
            $page->fillForm($browser, [
                'company_name' => self::TEST_COMPANY_NAME,
                'name' => self::TEST_NAME,
                'email' => self::TEST_EMAIL,
                'password' => self::TEST_PASSWORD,
                'password_confirmation' => self::TEST_PASSWORD,
                'terms_accepted' => true,
            ]);

            $page->submit($browser)
                ->waitForLocation(route('verification.notice', absolute: false))
                ->assertPathIs(route('verification.notice', absolute: false));

            // Get the user and generate verification URL
            $user = User::where('email', self::TEST_EMAIL)->first();
            $this->assertNotNull($user);
            $this->assertNull($user->email_verified_at);

            $company = Company::where('name', self::TEST_COMPANY_NAME)->first();
            $this->assertNotNull($company);
            $this->assertTrue($company->is($user->company));
            $this->assertSame(UserRole::OWNER, $user->role);
            $this->assertSame(UserStatus::ACTIVE, $user->status);

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
}
