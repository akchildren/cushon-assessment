<?php

namespace App\DataTransferObjects;

use Cknow\Money\Money;

final class InvestmentFundData implements DataTransferObject
{
    public function __construct(
        public string $id,
        public Money $amount,
    ) {}

    public static function fromArray(array $data): static
    {
        return new self(
            id: $data['id'],
            amount: $data['amount'],
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'amount' => $this->amount->getAmount(),
        ];
    }
}
