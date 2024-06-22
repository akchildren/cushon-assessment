<?php

namespace App\Http\Controllers\Investment;

use App\Actions\Investment\CreateEmployeeInvestmentAction;
use App\Actions\Investment\CreateRetailInvestmentAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateInvestmentRequest;
use App\Http\Resources\InvestmentResource;
use App\Models\Account\Account;
use Illuminate\Support\Facades\Auth;

final class CreateAccountInvestmentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function __invoke(
        Account $account,
        CreateInvestmentRequest $request,
        CreateEmployeeInvestmentAction $createEmployeeInvestmentAction,
        CreateRetailInvestmentAction $createRetailInvestmentAction,
    ): InvestmentResource {
        $action = match (Auth::user()?->company()->exists()) {
            true => $createEmployeeInvestmentAction,
            false => $createRetailInvestmentAction,
        };

        $result = $action->handle($account, $request->getFundsDto());

        return new InvestmentResource($result);
    }
}
