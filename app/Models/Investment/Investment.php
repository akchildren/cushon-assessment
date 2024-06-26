<?php

namespace App\Models\Investment;

use App\Models\Account\Account;
use App\Models\Fund;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

final class Investment extends Model
{
    use HasFactory;
    use HasUuids;

    public function amount(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->funds()?->sum('amount')
        );
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function funds(): BelongsToMany
    {
        return $this->belongsToMany(Fund::class)
            ->using(FundInvestment::class)
            ->withPivot('amount')
            ->withTimestamps();
    }
}
