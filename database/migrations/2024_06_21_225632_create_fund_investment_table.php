<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @TODO: Consider storing currency iso at later date
     */
    public function up(): void
    {
        Schema::create('fund_investment', static function (Blueprint $table) {
            $table->foreignUuid('investment_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('fund_id')->constrained();
            $table->integer('amount');
            //            $table->string('currency_iso');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fund_investment');
    }
};
