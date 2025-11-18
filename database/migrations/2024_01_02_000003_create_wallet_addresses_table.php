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
        Schema::create('wallet_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('symbol', 10);
            $table->string('chain', 50);
            $table->string('address')->nullable();
            $table->timestamps();

            // Unique constraint: one address per user per symbol
            $table->unique(['user_id', 'symbol'], 'idx_user_symbol');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_addresses');
    }
};

