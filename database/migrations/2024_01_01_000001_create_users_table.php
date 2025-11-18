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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('uid')->unique()->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->enum('account_type', ['user', 'administrator'])->default('user');
            $table->string('country')->nullable();
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('zip_code', 50)->nullable();
            $table->enum('id_verification_status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->enum('bank_verification_status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->string('front_id')->nullable();
            $table->string('back_id')->nullable();
            $table->string('bank_statement')->nullable();
            $table->string('avatar')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

