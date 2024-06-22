<?php

namespace App\Models\Investment;

use Cknow\Money\Casts\MoneyIntegerCast;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

final class FundInvestment extends Pivot
{
    use SoftDeletes;

    protected $fillable = [
        'amount',
    ];

    protected $casts = [
        'amount' => MoneyIntegerCast::class.':GBP',
    ];
}
