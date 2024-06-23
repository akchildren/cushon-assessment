<?php

namespace App\Http\Controllers\Investment;

use App\Http\Controllers\Controller;
use App\Http\Resources\InvestmentResource;
use App\Models\Account\Account;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class AccountInvestmentsIndexController extends Controller
{
    public function __invoke(
        Account $account,
    ): AnonymousResourceCollection {
        Gate::authorize('view', $account);

        if (! $account->investments()->exists()) {
            throw new NotFoundHttpException();
        }

        return InvestmentResource::collection($account->investments);
    }
}
