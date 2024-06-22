<?php

namespace App\Actions\Account;

use App\Actions\Action;
use app\Models\Account\Account;
use app\Models\Account\AccountType;
use App\Models\User;

/**
 * Basic action to create account
 */
final readonly class CreateAccountAction extends Action
{
    public function handle(
        User $user,
        AccountType $accountType,
    ): Account {
        return $user->accounts()->create([
            'account_type_id' => $accountType->id,
        ]);
    }
}
