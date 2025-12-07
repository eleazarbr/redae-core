<?php

namespace Tests\Feature\Auth;

use App\Enums\Company\UserRole;
use App\Enums\Company\UserStatus;
use App\Models\Company;
use App\Models\User;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    public function test_registration_screen_can_be_rendered()
    {
        $response = $this->get(route('register'));

        $response->assertStatus(200);
    }

    public function test_new_users_can_register()
    {
        $payload = [
            'company_name' => 'Test Company',
            'name' => 'Test User',
            'last_name' => 'User Last',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'terms_accepted' => true,
        ];

        $response = $this->post(route('register.store'), $payload);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard'));

        $company = Company::where('name', $payload['company_name'])->first();
        $this->assertNotNull($company);

        $user = User::where('email', $payload['email'])->first();
        $this->assertNotNull($user);
        $this->assertSame($payload['last_name'], $user->last_name);

        $this->assertTrue($company->is($user->company));
        $this->assertSame(UserRole::OWNER, $user->role);
        $this->assertSame(UserStatus::ACTIVE, $user->status);
    }

    public function test_users_can_register_without_last_name()
    {
        $payload = [
            'company_name' => 'Company Without Last Name',
            'name' => 'Test User',
            'email' => 'nolast@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'terms_accepted' => true,
        ];

        $response = $this->post(route('register.store'), $payload);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard'));

        $company = Company::where('name', $payload['company_name'])->first();
        $this->assertNotNull($company);

        $user = User::where('email', $payload['email'])->first();
        $this->assertNotNull($user);
        $this->assertNull($user->last_name);

        $this->assertTrue($company->is($user->company));
        $this->assertSame(UserRole::OWNER, $user->role);
        $this->assertSame(UserStatus::ACTIVE, $user->status);
    }
}
