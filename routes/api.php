<?php

use App\Http\Controllers\Api\Admin\AccountsController as AdminAccountsController;
use App\Http\Controllers\Api\Admin\SettingsController as AdminSettingsController;
use App\Http\Controllers\Api\Admin\TransactionsController as AdminTransactionsController;
use App\Http\Controllers\Api\Admin\TeamMembersController as AdminTeamMembersController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\PasswordController;
use App\Http\Controllers\Api\SettingsController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\WalletController;
use App\Http\Controllers\Api\WithdrawalController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    // Public routes
    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::get('/public/settings', [\App\Http\Controllers\Api\PublicSettingsController::class, 'index']);
    Route::get('/public/team-members', [\App\Http\Controllers\Api\PublicTeamMembersController::class, 'index']);
    
    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/auth/logout', [AuthController::class, 'logout']);
        Route::get('/auth/me', [AuthController::class, 'me']);
        Route::get('/users', [UserController::class, 'index']);
        Route::post('/users', [UserController::class, 'store']);
        
        // Dashboard routes
        Route::get('/customer/dashboard', [DashboardController::class, 'index']);
        Route::get('/customer/withdrawal-requests', [DashboardController::class, 'withdrawalRequests']);
        Route::get('/customer/crypto-prices', [DashboardController::class, 'cryptoPrices']);
        
        // Withdrawal routes
        Route::post('/customer/withdrawals', [WithdrawalController::class, 'store']);
        
        // Wallet routes
        Route::get('/customer/wallet', [WalletController::class, 'index']);
        
        // Settings routes
        Route::get('/customer/settings', [SettingsController::class, 'index']);
        Route::post('/customer/settings/address', [SettingsController::class, 'updateAddress']);
        Route::post('/customer/settings/upload-document', [SettingsController::class, 'uploadDocument']);
        
        // Password routes
        Route::post('/customer/password/change', [PasswordController::class, 'change']);
        
        // Contact routes
        Route::get('/customer/contact/info', [ContactController::class, 'info']);
        Route::post('/customer/contact', [ContactController::class, 'store']);
        
        // Admin routes (require administrator account type)
        Route::prefix('admin')->middleware('admin')->group(function () {
            // Accounts
            Route::get('/accounts', [AdminAccountsController::class, 'index']);
            Route::get('/accounts/{id}', [AdminAccountsController::class, 'show']);
            Route::put('/accounts/{id}', [AdminAccountsController::class, 'update']);
            Route::get('/accounts/{id}/wallets', [AdminAccountsController::class, 'getWallets']);
            Route::put('/accounts/{id}/wallets', [AdminAccountsController::class, 'updateWallets']);
            
            // Transactions
            Route::get('/transactions', [AdminTransactionsController::class, 'index']);
            Route::post('/transactions', [AdminTransactionsController::class, 'store']);
            Route::put('/transactions/{id}', [AdminTransactionsController::class, 'update']);
            
            // Settings
            Route::get('/settings', [AdminSettingsController::class, 'index']);
            Route::post('/settings', [AdminSettingsController::class, 'update']);
            Route::post('/settings/smtp', [AdminSettingsController::class, 'updateSMTP']);
            Route::post('/settings/upload-logo', [AdminSettingsController::class, 'uploadLogo']);
            
            // Team Members
            Route::get('/team-members', [AdminTeamMembersController::class, 'index']);
            Route::post('/team-members', [AdminTeamMembersController::class, 'store']);
            Route::put('/team-members/{id}', [AdminTeamMembersController::class, 'update']);
            Route::delete('/team-members/{id}', [AdminTeamMembersController::class, 'destroy']);
        });
    });
});

