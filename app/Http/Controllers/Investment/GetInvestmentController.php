<?php

namespace App\Http\Controllers\Investment;

use App\Http\Controllers\Controller;
use App\Http\Resources\InvestmentResource;
use App\Models\Investment\Investment;
use Illuminate\Support\Facades\Gate;

final class GetInvestmentController extends Controller
{
    public function __invoke(
        Investment $investment,
    ): InvestmentResource {
        Gate::authorize('view', $investment);

        return new InvestmentResource($investment);
    }
}
