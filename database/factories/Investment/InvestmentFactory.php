<?php

namespace Database\Factories\Investment;

use App\Models\Account\Account;
use App\Models\Fund;
use App\Models\Investment\Investment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Fund>
 */
final class InvestmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'account_id' => Account::factory()->create(),
        ];
    }

    /**
     * Indicate that the user has an isa account
     */
    public function hasFunds(): static
    {
        return $this->afterCreating(
            fn(Investment $investment) => $investment->funds()->attach(
                Fund::factory()->create(), [
                'amount' => random_int(10000, config('isa.annual_allowance')) * 100
            ])
        );
    }
}
