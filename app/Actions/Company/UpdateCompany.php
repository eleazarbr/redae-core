<?php

namespace App\Actions\Company;

use App\Models\Company;

final class UpdateCompany
{
    /**
     * Update the given company with the provided data.
     *
     * @param  array<string, mixed>  $data
     */
    public function execute(Company $company, array $data): Company
    {
        $company->fill([
            'name' => $data['name'],
            'slug' => $data['slug'],
            'domain' => $data['domain'] ?? null,
            'tax_id' => $data['tax_id'] ?? null,
            'country' => $data['country'] ?? null,
        ]);

        if (array_key_exists('billing_address', $data)) {
            $billingAddress = array_filter(
                $data['billing_address'] ?? [],
                static fn ($value) => $value !== null && $value !== ''
            );

            $company->billing_address_json = $billingAddress ?: null;
        }

        $company->save();

        return $company;
    }
}
