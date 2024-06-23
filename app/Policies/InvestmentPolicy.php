<?php

namespace App\Policies;

use App\Models\Investment\Investment;
use App\Models\User;

final readonly class InvestmentPolicy
{
    public function view (User $user, Investment $investment): bool
    {
        return $user->id === $investment->account->user->id;
    }
}
