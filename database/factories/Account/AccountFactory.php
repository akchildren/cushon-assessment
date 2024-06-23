<?php

namespace Database\Factories\Account;

use App\Enum\IsaType;
use app\Models\Account\Account;
use App\Models\Account\AccountType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Account>
 */
final class AccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->create(),
            'account_type_id' => AccountType::where('name', IsaType::ISA)->first(),
        ];
    }
}
