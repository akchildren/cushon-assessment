<?php

namespace App\Actions\Investment;

use App\Actions\Action;
use App\DataTransferObjects\InvestmentFund\InvestmentFundsDto;
use App\Exceptions\Investment\InvestmentAmountGreaterThanAnnualAllowanceException;
use App\Models\Account\Account;
use App\Models\Investment\Investment;
use Cknow\Money\Money;

/**
 * Basic action to create investment
 */
abstract readonly class CreateInvestmentAction extends Action
{
    /**
     * @throws InvestmentAmountGreaterThanAnnualAllowanceException
     */
    public function handle(
        Account $account,
        InvestmentFundsDto $investmentFundsDto,
    ): Investment {
        $this->validateAmountLessThanAnnualAllowance($account, $investmentFundsDto);

        $investment = $account->investments()->create();
        $this->attachInvestmentFunds($investment, $investmentFundsDto);

        return $investment->refresh();
    }

    /**
     * @todo: Future improvement to consider all of the users investment accounts as the annual limit is to the person not the individual account
     *
     * @param Account $account
     * @param InvestmentFundsDto $investmentFundsDto
     * @return void
     * @throws InvestmentAmountGreaterThanAnnualAllowanceException
     */
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

    private function attachInvestmentFunds(
        Investment $investment,
        InvestmentFundsDto $investmentFundsDto
    ): void {
        foreach ($investmentFundsDto->toArray() as $fund) {
            $investment
                ->funds()
                ->attach($fund->id, ['amount' => $fund->amount]);
        }
    }
}
