<?php

use App\Http\Controllers\Investment\AccountInvestmentsIndexController;
use App\Http\Controllers\Investment\CreateAccountInvestmentController;
use App\Http\Controllers\Investment\GetInvestmentController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(static function () {
    /**
     * TODO: Out of scope of assignment
     *  - Patch
     *  - Delete
     */
    Route::prefix('account/{account}/investment')->group(static function () {
        Route::get('/', AccountInvestmentsIndexController::class);
        Route::post('/', CreateAccountInvestmentController::class);
    });

    Route::get('investment/{investment}',GetInvestmentController::class);
});
