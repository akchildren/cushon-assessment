<?php

namespace App\Models\Account;

use App\Models\Fund;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Account extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    /**
     * -------------------------------------------------
     *                  RELATIONSHIPS
     * -------------------------------------------------
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function accountType(): HasOne
    {
        return $this->hasOne(AccountType::class);
    }

    public function funds(): BelongsToMany
    {
        return $this->belongsToMany(Fund::class)
            ->using(AccountFund::class)
            ->withPivot('amount')
            ->withTimestamps();
    }
}
