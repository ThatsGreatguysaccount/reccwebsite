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
        Schema::create('withdrawal_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('type', ['crypto', 'fiat']);
            $table->string('asset', 10);
            $table->decimal('amount', 20, 8);
            $table->decimal('amount_usd', 15, 2);
            $table->string('wallet_address')->nullable();
            $table->text('bank_account')->nullable();
            $table->decimal('network_fee', 20, 8)->default(0.00000000);
            $table->enum('status', ['pending', 'confirmed', 'rejected'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->unsignedBigInteger('confirmed_by')->nullable();
            $table->unsignedBigInteger('rejected_by')->nullable();
            $table->foreign('confirmed_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('rejected_by')->references('id')->on('users')->onDelete('set null');
            $table->string('transaction_hash')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('user_id', 'idx_user_id');
            $table->index(['user_id', 'status'], 'idx_user_status');
            $table->index('status', 'idx_status');
            $table->index('type', 'idx_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawal_requests');
    }
};

