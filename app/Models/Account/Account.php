<?php

namespace App\Models\Account;

use App\Models\Investment\Investment;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin Builder<Account>
 */
final class Account extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    protected $fillable = [
        'account_type_id',
    ];

    /**
     * @note: For MVP, I have excluded any logic surrounding interested accrued on ISA, this will just return the investments totals
     */
    public function amount(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->investments?->sum('amount')
        );
    }

    /**
     * -------------------------------------------------
     *                  RELATIONSHIPS
     * -------------------------------------------------
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function accountType(): BelongsTo
    {
        return $this->belongsTo(AccountType::class);
    }

    public function investments(): HasMany
    {
        return $this->hasMany(Investment::class);
    }
}
