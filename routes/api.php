<?php

use App\Http\Controllers\Investment\CreateAccountInvestmentController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(static function () {
    /**
     * TODO: Out of scope of assignment
     *  - Get [Index]
     *  - Patch
     *  - Delete
     */
    Route::prefix('account/{account}/investment')->group(static function () {
        Route::get('/', static fn () => 'todo');
        Route::post('/', CreateAccountInvestmentController::class);
    });
});
