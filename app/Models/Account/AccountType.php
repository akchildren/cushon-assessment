<?php

namespace App\Models\Account;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class AccountType extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = ['name'];

    public function scopeName(Builder $query, string $name): Builder
    {
        return $query->where('name', $name);
    }
}
