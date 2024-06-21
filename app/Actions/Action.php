<?php

namespace App\Actions;

use Lorisleiva\Actions\Concerns\AsAction;

/**
 * Action abstract introduced to use command design pattern
 *
 * @note: Package concept in use: lorisleiva/laravel-actions
 */
abstract readonly class Action
{
    use AsAction;
}
