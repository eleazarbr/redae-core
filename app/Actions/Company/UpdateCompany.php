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
            $company->billing_address_json = $this->formatBillingAddress($data['billing_address'] ?? []);
        }

        $company->save();

        return $company;
    }

    /**
     * @param  array<string, mixed>  $billingAddress
     */
    private function formatBillingAddress(array $billingAddress): ?array
    {
        $orderedKeys = ['line1', 'city', 'state', 'postal_code'];
        $formattedAddress = [];

        foreach ($orderedKeys as $key) {
            $value = $billingAddress[$key] ?? null;

            if ($value === null || $value === '') {
                continue;
            }

            $formattedAddress[$key] = $value;
        }

        return $formattedAddress ?: null;
    }
}
