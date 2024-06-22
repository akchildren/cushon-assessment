<?php

namespace App\Actions\Investment;

use App\Actions\Action;
use App\DataTransferObjects\InvestmentFundsDto;
use app\Models\Account\Account;
use App\Models\Investment\Investment;

/**
 * Basic action to create investment
 */
abstract readonly class CreateInvestmentAction extends Action
{
    public function __construct() {}

    public function handle(
        Account $account,
        InvestmentFundsDto $investmentFundsDto,
    ): Investment {
        $investment = $account->investments()->create();

        foreach ($investmentFundsDto->toArray() as $fund) {
            $investment
                ->funds()
                ->attach($fund->id, ['amount' => $fund->amount]);
        }

        return $investment->refresh();
    }
}
