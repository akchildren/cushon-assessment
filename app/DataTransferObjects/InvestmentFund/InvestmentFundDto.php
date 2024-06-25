<?php

namespace App\DataTransferObjects\InvestmentFund;

use App\DataTransferObjects\DataTransferObject;
use Cknow\Money\Money;

final class InvestmentFundDto implements DataTransferObject
{
    public function __construct(
        public string $id,
        public Money $amount,
    ) {}

    public static function fromArray(array $data): static
    {
        return new self(
            id: $data['id'],
            amount: Money::parse($data['amount']),
        );
    }

    public function toArray(): array
    {
        return [
            'fund_id' => $this->id,
            'amount' => $this->amount->getAmount(),
        ];
    }
}
