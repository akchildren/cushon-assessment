<?php

namespace App\DataTransferObjects;

use App\Models\Account\AccountType;

final class AccountTypeDto implements DataTransferObject
{
    public function __construct(
        public AccountType $accountType,
    ) {}

    public static function fromArray(array $data): static
    {
        return new self(
            accountType: AccountType::name($data['account_type'])->first(),
        );
    }

    public function toArray(): array
    {
        return [
            'account_type' => $this->accountType,
        ];
    }
}
