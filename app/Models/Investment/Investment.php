<?php

namespace App\Models\Investment;

use App\Models\Account\Account;
use App\Models\Fund;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function account(): HasOne
    {
        return $this->hasOne(Account::class);
    }

    public function funds(): BelongsToMany
    {
        return $this->belongsToMany(Fund::class)
            ->using(InvestmentFund::class)
            ->withPivot('amount')
            ->withTimestamps();
    }
}
