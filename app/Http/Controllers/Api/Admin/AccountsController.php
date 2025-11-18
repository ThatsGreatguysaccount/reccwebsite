<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Models\User;
use App\Models\WalletAddress;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountsController extends ApiController
{
    /**
     * Get all user accounts
     */
    public function index(): JsonResponse
    {
        try {
            $accounts = User::select([
                'id',
                'username',
                'email',
                'uid',
                'first_name',
                'last_name',
                'account_type',
                'avatar',
                'country',
                'address1',
                'address2',
                'zip_code',
                'created_at'
            ])->orderBy('created_at', 'desc')->get();

            return $this->success([
                'accounts' => $accounts
            ], 'Accounts retrieved successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to retrieve accounts: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Get a specific user account
     */
    public function show($id): JsonResponse
    {
        try {
            $account = User::findOrFail($id);
            
            return $this->success([
                'account' => $account
            ], 'Account retrieved successfully');
        } catch (\Exception $e) {
            return $this->error('Account not found', 404);
        }
    }

    /**
     * Update a user account
     */
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $account = User::findOrFail($id);

            $validated = $request->validate([
                'username' => 'sometimes|string|max:255|unique:users,username,' . $id,
                'first_name' => 'sometimes|string|max:255',
                'last_name' => 'sometimes|string|max:255',
                'email' => 'sometimes|string|email|max:255|unique:users,email,' . $id,
                'account_type' => 'sometimes|in:user,administrator',
                'country' => 'sometimes|string|max:255',
                'address1' => 'sometimes|string|max:500',
                'address2' => 'sometimes|string|max:500',
                'zip_code' => 'sometimes|string|max:255',
                'password' => 'sometimes|string|min:6|confirmed',
            ]);

            // Hash password if provided
            if (isset($validated['password'])) {
                $validated['password'] = Hash::make($validated['password']);
                unset($validated['password_confirmation']);
            }

            $account->update($validated);

            return $this->success([
                'account' => $account
            ], 'Account updated successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->error('Validation failed', 422, $e->errors());
        } catch (\Exception $e) {
            return $this->error('Failed to update account: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Get user's wallet addresses
     */
    public function getWallets($id): JsonResponse
    {
        try {
            $user = User::findOrFail($id);
            $wallets = WalletAddress::where('user_id', $user->id)
                ->get()
                ->pluck('address', 'symbol')
                ->toArray();

            // Ensure all wallets are returned
            $allWallets = [
                'BTC' => $wallets['BTC'] ?? null,
                'ETH' => $wallets['ETH'] ?? null,
                'TRX' => $wallets['TRX'] ?? null,
                'USDT' => $wallets['USDT'] ?? null,
            ];

            return $this->success([
                'wallets' => $allWallets
            ], 'Wallets retrieved successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to retrieve wallets: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Update user's wallet addresses
     */
    public function updateWallets(Request $request, $id): JsonResponse
    {
        try {
            $user = User::findOrFail($id);

            $validated = $request->validate([
                'wallets' => 'required|array',
                'wallets.BTC' => 'nullable|string|max:255',
                'wallets.ETH' => 'nullable|string|max:255',
                'wallets.TRX' => 'nullable|string|max:255',
                'wallets.USDT' => 'nullable|string|max:255',
            ]);

            $wallets = $validated['wallets'];
            $cryptoAssets = ['BTC', 'ETH', 'TRX', 'USDT'];

            foreach ($cryptoAssets as $symbol) {
                $address = $wallets[$symbol] ?? null;
                
                WalletAddress::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'symbol' => $symbol
                    ],
                    [
                        'chain' => $this->getChainForSymbol($symbol),
                        'address' => $address ?: null
                    ]
                );
            }

            return $this->success([], 'Wallets updated successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->error('Validation failed', 422, $e->errors());
        } catch (\Exception $e) {
            return $this->error('Failed to update wallets: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Get chain name for crypto symbol
     */
    private function getChainForSymbol(string $symbol): string
    {
        $chains = [
            'BTC' => 'Bitcoin',
            'ETH' => 'Ethereum',
            'TRX' => 'Tron',
            'USDT' => 'Tron' // USDT can be on multiple chains, defaulting to Tron
        ];

        return $chains[$symbol] ?? $symbol;
    }
}

