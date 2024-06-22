<?php

namespace Database\Factories;

use App\Actions\Account\CreateAccountAction;
use App\Enum\IsaType;
use App\Models\Account\AccountType;
use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Indicate that the user is an employee
     */
    public function employee(?Company $company = null): static
    {
        $company ??= Company::factory()->create();

        return $this->afterCreating(
            fn (User $user) => $user->company()->associate($company)
        );
    }

    /**
     * Indicate that the user has an isa account
     */
    public function hasIsaAccount(): static
    {
        return $this->afterCreating(
            fn (User $user) => app()->make(CreateAccountAction::class)->handle(
                $user,
                AccountType::name(IsaType::ISA->value)->first()
            )
        );
    }
}
