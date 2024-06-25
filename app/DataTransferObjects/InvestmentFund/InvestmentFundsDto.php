<?php

namespace App\DataTransferObjects\InvestmentFund;

use App\DataTransferObjects\DataTransferObject;

final class InvestmentFundsDto implements DataTransferObject
{
    public function __construct(
        public array $data,
    ) {}

    public static function fromArray(array $data): static
    {
        return new self(
            array_map(
                static fn ($fundData) => InvestmentFundDto::fromArray($fundData),
                $data
            )
        );
    }

    public function toArray(): array
    {
        return $this->data;
    }
}
