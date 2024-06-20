<?php

namespace app\Models\Isa;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class IsaType extends Model
{
    use HasFactory;
    use HasUuids;

    //    protected $guarded = [];
    protected $fillable = ['name'];
}
