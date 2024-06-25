<?php

namespace App\Http\Controllers\Account;

use App\Actions\Account\Employee\CreateEmployeeAccountAction;
use App\Actions\Account\Retail\CreateRetailAccountAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAccountRequest;
use App\Http\Resources\AccountResource;
use Illuminate\Support\Facades\Auth;

final class CreateAccountController extends Controller
{
    public function __invoke(
        CreateAccountRequest $request,
        CreateEmployeeAccountAction $createEmployeeAccountAction,
        CreateRetailAccountAction $createRetailAccountAction,
    ): AccountResource {
        $action = match (Auth::user()?->company()->exists()) {
            true => $createEmployeeAccountAction,
            false => $createRetailAccountAction,
        };

        $result = $action->handle(
            $request->user(),
            $request->getAccountTypeDto()->accountType
        );

        return new AccountResource($result);
    }
}
