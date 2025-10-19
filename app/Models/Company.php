<?php

namespace App\Models;

use App\Models\Concerns\CompanyIsBillable;
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

    /**
     * Get the users for the company.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
