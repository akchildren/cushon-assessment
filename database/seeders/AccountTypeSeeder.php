<?php

namespace Database\Seeders;

use App\Enum\Isa\IsaType;
use App\Models\Account\AccountType;
use Illuminate\Database\Seeder;

final class AccountTypeSeeder extends Seeder
{
    private array $accountTypes = [
        IsaType::ISA,
        IsaType::LIFETIME_ISA,
        IsaType::JUNIOR_ISA,
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->accountTypes as $accountType) {
            AccountType::updateOrCreate([
                'name' => $accountType->value,
            ]);
        }
    }
}
