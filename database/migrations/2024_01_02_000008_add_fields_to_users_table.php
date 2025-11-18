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
        Schema::table('users', function (Blueprint $table) {
            // Add new fields if they don't exist
            if (!Schema::hasColumn('users', 'first_name')) {
                $table->string('first_name')->nullable()->after('uid');
            }
            if (!Schema::hasColumn('users', 'last_name')) {
                $table->string('last_name')->nullable()->after('first_name');
            }
            if (!Schema::hasColumn('users', 'account_type')) {
                $table->enum('account_type', ['user', 'administrator'])->default('user')->after('last_name');
            }
            if (!Schema::hasColumn('users', 'country')) {
                $table->string('country')->nullable()->after('account_type');
            }
            if (!Schema::hasColumn('users', 'address1')) {
                $table->string('address1')->nullable()->after('country');
            }
            if (!Schema::hasColumn('users', 'address2')) {
                $table->string('address2')->nullable()->after('address1');
            }
            if (!Schema::hasColumn('users', 'zip_code')) {
                $table->string('zip_code', 50)->nullable()->after('address2');
            }
            if (!Schema::hasColumn('users', 'id_verification_status')) {
                $table->enum('id_verification_status', ['pending', 'verified', 'rejected'])->default('pending')->after('zip_code');
            }
            if (!Schema::hasColumn('users', 'bank_verification_status')) {
                $table->enum('bank_verification_status', ['pending', 'verified', 'rejected'])->default('pending')->after('id_verification_status');
            }
            if (!Schema::hasColumn('users', 'front_id')) {
                $table->string('front_id')->nullable()->after('bank_verification_status');
            }
            if (!Schema::hasColumn('users', 'back_id')) {
                $table->string('back_id')->nullable()->after('front_id');
            }
            if (!Schema::hasColumn('users', 'bank_statement')) {
                $table->string('bank_statement')->nullable()->after('back_id');
            }
            if (!Schema::hasColumn('users', 'avatar')) {
                $table->string('avatar')->nullable()->after('bank_statement');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'first_name',
                'last_name',
                'account_type',
                'country',
                'address1',
                'address2',
                'zip_code',
                'id_verification_status',
                'bank_verification_status',
                'front_id',
                'back_id',
                'bank_statement',
                'avatar'
            ]);
        });
    }
};

