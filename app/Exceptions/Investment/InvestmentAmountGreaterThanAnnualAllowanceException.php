<?php

namespace App\Exceptions\Investment;

use Exception;
use Illuminate\Http\Response;

final class InvestmentAmountGreaterThanAnnualAllowanceException extends Exception
{
    public const string MESSAGE = 'Required investment amount is larger than annual allowance';

    public function render(): Response
    {
        return response(
            self::MESSAGE,
            400
        );
    }
}
