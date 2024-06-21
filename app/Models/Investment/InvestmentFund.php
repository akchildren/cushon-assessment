<?php

namespace App\Models\Investment;

use Cknow\Money\Casts\MoneyIntegerCast;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

final class InvestmentFund extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    protected $fillable = [
        'amount',
        'currency_iso',
    ];

    protected $casts = [
        'amount' => MoneyIntegerCast::class.':GBP',
    ];
}
