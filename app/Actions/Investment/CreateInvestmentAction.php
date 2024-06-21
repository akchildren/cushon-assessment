<?php

namespace App\Actions\Investment;

use App\Actions\Action;
use app\Models\Account\Account;

/**
 * Basic action to create investment
 */
final readonly class CreateInvestmentAction extends Action
{
    public function __construct() {}

    public function handle(
        Account $account,
        array $funds,
    ): Account {
        // Todo : Logic to create investment and link funds
        $investment = $account->investments()->create();
        $investment->funds()->sync($funds);

        return $account->refresh();
    }
}
