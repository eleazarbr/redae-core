<?php

namespace App\Http\Requests\Company;

use App\Models\Company;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UpdateCompanyRequest extends FormRequest
{
    private const MAX_STRING_LENGTH = 'max:255';

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->company !== null;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if (! $this->filled('name')) {
            return;
        }

        $companyId = $this->user()?->company_id;
        $baseSlug = Str::slug($this->input('name'));
        $slug = $baseSlug;
        $suffix = 1;

        if ($slug !== '') {
            while (
                Company::query()
                    ->where('slug', $slug)
                    ->when($companyId, fn ($query) => $query->where('id', '!=', $companyId))
                    ->exists()
            ) {
                $slug = $baseSlug.'-'.$suffix;
                $suffix++;
            }
        }

        if ($slug === '' && $this->user()?->company) {
            $slug = (string) $this->user()->company->slug;
        }

        $this->merge([
            'slug' => $slug,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $companyId = $this->user()?->company_id;

        return [
            'name' => ['required', 'string', self::MAX_STRING_LENGTH],
            'slug' => [
                'required',
                'string',
                self::MAX_STRING_LENGTH,
                Rule::unique('companies', 'slug')->ignore($companyId),
            ],
            'domain' => [
                'nullable',
                'string',
                self::MAX_STRING_LENGTH,
                'regex:/^(?!-)(?:[A-Za-z0-9](?:[A-Za-z0-9-]{0,61}[A-Za-z0-9])?)(?:\\.(?!-)(?:[A-Za-z0-9](?:[A-Za-z0-9-]{0,61}[A-Za-z0-9])?))+$/',
                Rule::unique('companies', 'domain')->ignore($companyId),
            ],
            'tax_id' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('companies', 'tax_id')->ignore($companyId),
            ],
            'country' => ['nullable', 'string', 'size:2'],
            'billing_address' => ['nullable', 'array'],
            'billing_address.line1' => ['nullable', 'string', self::MAX_STRING_LENGTH],
            'billing_address.city' => ['nullable', 'string', self::MAX_STRING_LENGTH],
            'billing_address.state' => ['nullable', 'string', self::MAX_STRING_LENGTH],
            'billing_address.postal_code' => ['nullable', 'string', 'max:20'],
        ];
    }
}
