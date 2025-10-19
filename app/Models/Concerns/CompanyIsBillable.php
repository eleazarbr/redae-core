<?php

namespace App\Models\Concerns;

if (trait_exists('Laravel\\Cashier\\Billable')) {
    trait CompanyIsBillable
    {
        use \Laravel\Cashier\Billable;
    }
} else {
    trait CompanyIsBillable
    {
        // Cashier not installed; trait intentionally left empty.
    }
}
