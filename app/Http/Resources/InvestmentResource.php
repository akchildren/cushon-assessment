<?php

namespace App\Http\Resources;

use Cknow\Money\Money;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class InvestmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => (string) $this->id,
            'account_id' => (string) $this->account_id,
            'funds' => FundInvestmentResource::collection($this->funds),
            'amount' => $this->amount ? Money::parse($this->amount)->formatByDecimal() : null,
            'created_at' => (string) $this->created_at->toDateTimeString(),
        ];
    }
}
