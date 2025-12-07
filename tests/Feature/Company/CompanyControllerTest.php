<?php

namespace Tests\Feature\Company;

use App\Models\Company;
use App\Models\User;
use Tests\TestCase;

class CompanyControllerTest extends TestCase
{
    private const TEST_COMPANY_NAME = 'Acme Labs';

    public function test_company_settings_page_is_displayed(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get(route('company.index'));

        $response->assertOk();
    }

    public function test_company_information_can_be_updated(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $company = $user->company;

        $response = $this
            ->actingAs($user)
            ->from(route('company.index'))
            ->patch(route('company.update'), [
                'name' => self::TEST_COMPANY_NAME,
                'domain' => null,
                'tax_id' => 'RFC-12345',
                'country' => 'US',
                'billing_address' => [
                    'line1' => '123 Main St',
                    'city' => 'Austin',
                    'state' => 'TX',
                    'postal_code' => '73301',
                ],
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('company.index'));

        $company->refresh();

        $this->assertSame(self::TEST_COMPANY_NAME, $company->name);
        $this->assertSame('acme-labs', $company->slug);
        $this->assertSame('RFC-12345', $company->tax_id);
        $this->assertSame('US', $company->country);
        $this->assertSame([
            'line1' => '123 Main St',
            'city' => 'Austin',
            'state' => 'TX',
            'postal_code' => '73301',
        ], $company->billing_address_json);
    }

    public function test_domain_can_be_saved_before_dns_is_live(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $company = $user->company;

        $response = $this
            ->actingAs($user)
            ->from(route('company.index'))
            ->patch(route('company.update'), [
                'name' => self::TEST_COMPANY_NAME,
                'domain' => 'app.example.test',
                'tax_id' => null,
                'country' => null,
                'billing_address' => [],
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('company.index'));

        $company->refresh();

        $this->assertSame('app.example.test', $company->domain);
    }

    public function test_slug_is_incremented_when_name_conflicts_with_existing_company(): void
    {
        $company = Company::factory()->create(['slug' => 'original-company']);
        /** @var User $user */
        $user = User::factory()->create([
            'company_id' => $company->id,
        ]);

        Company::factory()->create(['slug' => 'acme-labs']);

        $response = $this
            ->actingAs($user)
            ->from(route('company.index'))
            ->patch(route('company.update'), [
                'name' => self::TEST_COMPANY_NAME,
                'domain' => null,
                'tax_id' => null,
                'country' => null,
                'billing_address' => [],
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('company.index'));

        $this->assertSame('acme-labs-1', $company->refresh()->slug);
    }

    public function test_tax_id_must_be_unique(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        Company::factory()->create([
            'tax_id' => 'RFC-12345',
            'slug' => 'existing-company',
        ]);

        $response = $this
            ->actingAs($user)
            ->from(route('company.index'))
            ->patch(route('company.update'), [
                'name' => 'New Name',
                'domain' => null,
                'tax_id' => 'RFC-12345',
                'country' => null,
                'billing_address' => [],
            ]);

        $response
            ->assertSessionHasErrors('tax_id')
            ->assertRedirect(route('company.index'));
    }
}
