<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition(): array
    {
        return [
            'Institution_Name' => $this->faker->company(),
            'Contact_Person' => $this->faker->name(),
            'Email' => $this->faker->unique()->companyEmail(),
            'Phone' => $this->faker->phoneNumber(),
            'Address' => $this->faker->address(),
            'Customer_Type' => $this->faker->randomElement(['Hospital', 'Clinic', 'Pharmacy', 'Laboratory', 'Government']),
            'Segment' => $this->faker->randomElement(['Enterprise', 'SMB', 'Government', 'Individual']),
            'Status' => $this->faker->randomElement(['Active', 'Inactive', 'Prospect']),
            'Total_Purchases' => $this->faker->randomFloat(2, 0, 500000),
            'Notes' => $this->faker->optional()->sentence(),
        ];
    }

    /**
     * State for active customers
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'Status' => 'Active',
        ]);
    }

    /**
     * State for prospect customers
     */
    public function prospect(): static
    {
        return $this->state(fn (array $attributes) => [
            'Status' => 'Prospect',
        ]);
    }
}
