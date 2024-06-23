<?php

namespace App\Policies;

use App\Models\Account\Account;
use App\Models\User;

final readonly class AccountPolicy
{
    public function view(User $user, Account $account): bool
    {
        return $user->id === $account->user->id;
    }
}
