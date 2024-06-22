<?php

namespace App\Http\Controllers\Investment;

use App\Http\Controllers\Controller;
use App\Http\Resources\InvestmentResource;
use App\Models\Investment\Investment;

final class GetInvestmentController extends Controller
{
    public function __invoke(
        Investment $investment,
    ): InvestmentResource {
        return new InvestmentResource($investment);
    }
}
