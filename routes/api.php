<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(static function () {
    /**
     * TODO: Out of scope of assignment
     *  - Get [Index]
     *  - Patch
     *  - Delete
     */
    Route::prefix('/api/user/{user}/isa')->group(static function () {
        Route::get('/');
        Route::post('/');
    });
});
