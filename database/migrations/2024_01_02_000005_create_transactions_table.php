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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('withdrawal_request_id')->nullable()->constrained('withdrawal_requests')->onDelete('set null');
            $table->enum('type', ['deposit', 'withdrawal']);
            $table->string('asset', 10);
            $table->decimal('amount', 20, 8);
            $table->decimal('amount_usd', 15, 2);
            $table->enum('status', ['pending', 'completed', 'failed', 'cancelled'])->default('pending');
            $table->string('wallet_address')->nullable();
            $table->string('transaction_hash')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('date_time');
            $table->timestamps();

            // Indexes
            $table->index('user_id', 'idx_user_id');
            $table->index(['user_id', 'date_time'], 'idx_user_date');
            $table->index('status', 'idx_status');
            $table->index('type', 'idx_type');
            $table->index('withdrawal_request_id', 'idx_withdrawal_request');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};

