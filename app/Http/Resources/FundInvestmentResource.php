<?php

namespace App\Http\Resources;

use Cknow\Money\Money;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class FundInvestmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $pivot = $this->pivot;

        return [
            'fund_id' => (string) $pivot->fund_id,
            'investment_id' => (string) $pivot->investment_id,
            'amount' => $pivot->amount ? Money::parse($pivot->amount)->formatByDecimal() : null,
            'created_at' => (string) $pivot->created_at->toDateTimeString(),
        ];
    }
}
