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
        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('name')->nullable();
            $table->string('email');
            $table->string('subject');
            $table->text('message');
            $table->enum('status', ['new', 'read', 'replied', 'archived'])->default('new');
            $table->timestamp('read_at')->nullable();
            $table->timestamp('replied_at')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('user_id', 'idx_user_id');
            $table->index('status', 'idx_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_messages');
    }
};

