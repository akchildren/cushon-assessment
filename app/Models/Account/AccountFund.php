<?php

namespace App\Models\Account;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

final class AccountFund extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    /**
     * $table->integer('amount');
     * $table->string('currency_iso');
     */
}
