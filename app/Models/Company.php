<?php

namespace App\Models;

use App\Models\Concerns\CompanyIsBillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use CompanyIsBillable;
    use HasFactory;

    protected $table = 'companies';

    protected $fillable = [
        'name',
        'slug',
        'domain',
        'tax_id',
        'billing_address_json',
        'country',
    ];

    protected $casts = [
        'billing_address_json' => 'array',
    ];

    protected function billingAddressJson(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->formatBillingAddress(
                is_array($value) ? $value : (is_string($value) ? json_decode($value, true) : [])
            ),
        );
    }

    private function formatBillingAddress(?array $value): ?array
    {
        if (! $value) {
            return null;
        }

        $orderedKeys = ['line1', 'city', 'state', 'postal_code'];
        $formattedValue = [];

        foreach ($orderedKeys as $key) {
            $field = $value[$key] ?? null;

            if ($field === null || $field === '') {
                continue;
            }

            $formattedValue[$key] = $field;
        }

        return $formattedValue ?: null;
    }

    /**
     * Get the users for the company.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
