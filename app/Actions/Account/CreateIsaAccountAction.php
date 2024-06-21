<?php

namespace App\Actions\Account;

use App\Actions\Action;
use App\Enum\IsaType;
use app\Models\Account\Account;
use app\Models\Account\AccountType;
use App\Models\User;

/**
 * Basic action to create isa account
 */
final readonly class CreateIsaAccountAction extends Action
{
    public function __construct(
        private CreateAccountAction $createUserIsaAction
    ) {}

    public function handle(
        User $user,
    ): Account {
        return $this->createUserIsaAction->handle(
            $user,
            AccountType::name(IsaType::ISA)->first(),
        );
    }
}
