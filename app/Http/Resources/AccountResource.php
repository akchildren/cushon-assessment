<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class AccountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @todo : Add to docs about active accounts
     * @todo : Add to docs about interest calculations etc
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => (string) $this->id,
            'user_id' => (string) $this->user_id,
            'account_type' => (string) $this->accountType?->name,
            'investments' => InvestmentResource::collection($this->investments),
            //            'amount' => $this->amount ? Money::parse($this->amount)->format() : null,
            'created_at' => (string) $this->created_at->toDateTimeString(),
        ];
    }
}
