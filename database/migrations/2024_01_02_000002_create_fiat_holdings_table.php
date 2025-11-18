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
        Schema::create('fiat_holdings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('symbol', 10);
            $table->decimal('balance', 15, 2)->default(0.00);
            $table->decimal('value_usd', 15, 2)->default(0.00);
            $table->decimal('allocation_percentage', 5, 2)->default(0.00);
            $table->timestamps();

            // Unique constraint: one holding per user per symbol
            $table->unique(['user_id', 'symbol'], 'idx_user_symbol');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fiat_holdings');
    }
};

