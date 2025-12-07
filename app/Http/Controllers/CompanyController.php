<?php

namespace App\Http\Controllers;

use App\Actions\Company\UpdateCompany as UpdateCompanyAction;
use App\Http\Requests\Company\UpdateCompanyRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Inertia\Inertia;
use Inertia\Response;

class CompanyController extends Controller
{
    /**
     * Display the company settings page.
     */
    public function index(Request $request): Response
    {
        $company = $request->user()?->company;

        abort_unless($company, 404);

        return Inertia::render('company/Index', [
            'status' => $request->session()->get('status'),
            'company' => [
                'id' => $company->id,
                'name' => $company->name,
                'slug' => $company->slug,
                'domain' => $company->domain,
                'tax_id' => $company->tax_id,
                'country' => $company->country,
                'billing_address' => [
                    'line1' => Arr::get($company->billing_address_json, 'line1'),
                    'city' => Arr::get($company->billing_address_json, 'city'),
                    'state' => Arr::get($company->billing_address_json, 'state'),
                    'postal_code' => Arr::get($company->billing_address_json, 'postal_code'),
                ],
            ],
        ]);
    }

    /**
     * Update the company information.
     */
    public function update(UpdateCompanyRequest $request, UpdateCompanyAction $updateCompany): RedirectResponse
    {
        $company = $request->user()->company;

        abort_unless($company, 404);

        $updateCompany->execute($company, $request->validated());

        return back()->with('status', 'company-updated');
    }
}
