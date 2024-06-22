<?php

namespace App\Http\Requests;

use App\DataTransferObjects\InvestmentFundsDto;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

final class CreateInvestmentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'funds' => [
                'required',
                'array',
                'size:1', // @note: Currently limited to one fund with scope to increase number of fund investments in the future
            ],
            'funds.*' => [
                'required',
                'array',
            ],
            'funds.*.id' => [
                'required',
                'exists:funds',
            ],
            // Rule required to ensure that amount does not put over the annual amount + what is currently in the investment
            'funds.*.amount' => [
                'required',
                'integer', // @note: Default is unsigned
            ],
            'funds.*.currency_iso' => [
                'nullable',
                'string',
                'max:3', // @note: Future improvement to introduce available list of currency isos to validate against
            ],
        ];
    }

    public function getFundsDto(): ?InvestmentFundsDto
    {
        if ($this->has('funds')) {
            return InvestmentFundsDto::fromArray($this->funds);
        }

        return null;
    }
}
