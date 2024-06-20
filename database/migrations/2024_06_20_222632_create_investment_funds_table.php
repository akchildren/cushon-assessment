<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('investment_funds', static function (Blueprint $table) {
            $table->uuid('id');
            $table->foreignUuid('investment_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('fund_id')->constrained();
            $table->integer('amount');
            $table->string('currency_iso');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investment_funds');
    }
};