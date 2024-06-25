<?php

namespace App\Http\Requests;

use App\DataTransferObjects\AccountType\AccountTypeDto;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

final class CreateAccountRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'account_type' => [
                'required',
                'exists:account_types,name',
            ],
        ];
    }

    public function getAccountTypeDto(): AccountTypeDto
    {
        return AccountTypeDto::fromArray($this->safe(['account_type']));
    }
}
