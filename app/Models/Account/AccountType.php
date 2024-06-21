<?php

namespace App\Models\Account;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class AccountType extends Model
{
    use HasFactory;
    use HasUuids;

    //    protected $guarded = [];
    protected $fillable = ['name'];
}
