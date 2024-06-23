<?php

namespace App\Actions\Investment;

use App\Actions\Action;
use App\DataTransferObjects\InvestmentFundsDto;
use App\Exceptions\InvestmentAmountGreaterThanAnnualAllowanceException;
use App\Models\Account\Account;
use App\Models\Investment\Investment;
use Cknow\Money\Money;

/**
 * Basic action to create investment
 */
abstract readonly class CreateInvestmentAction extends Action
{
    public function __construct() {}

    /**
     * @throws InvestmentAmountGreaterThanAnnualAllowanceException
     */
    public function handle(
        Account $account,
        InvestmentFundsDto $investmentFundsDto,
    ): Investment {
        $this->validateAmountLessThanAnnualAllowance($account, $investmentFundsDto);

        $investment = $account->investments()->create();

        foreach ($investmentFundsDto->toArray() as $fund) {
            $investment
                ->funds()
                ->attach($fund->id, ['amount' => $fund->amount]);
        }

        return $investment->refresh();
    }

    public function validateAmountLessThanAnnualAllowance(
        Account $account,
        InvestmentFundsDto $investmentFundsDto
    ): void {
        $total = Money::parse($account->amount);

        foreach ($investmentFundsDto->toArray() as $dto) {
            $total = $total->add($dto->amount);
        }

        // @TODO: Future improvement would be to store the annual amount spent and compare it yearly, just using static value for showcase
        if ($total->getAmount() > config('investment.annual_allowance')) {
            throw new InvestmentAmountGreaterThanAnnualAllowanceException();
        }
    }
}
