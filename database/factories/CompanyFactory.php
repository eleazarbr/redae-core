<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    protected $model = Company::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'slug' => $this->faker->unique()->slug,
            'domain' => $this->faker->optional()->domainName,
            'tax_id' => $this->faker->optional()->unique()->bothify('??#########'),
            'billing_address_json' => $this->faker->optional()->randomElement([
                [
                    'street' => $this->faker->streetAddress,
                    'city' => $this->faker->city,
                    'state' => $this->faker->state,
                    'postal_code' => $this->faker->postcode,
                    'country' => $this->faker->countryCode,
                ],
                null,
            ]),
            'country' => $this->faker->optional()->countryCode,
        ];
    }
}
