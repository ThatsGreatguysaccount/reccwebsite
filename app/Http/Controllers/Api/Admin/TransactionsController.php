<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Models\Transaction;
use App\Models\WithdrawalRequest;
use App\Models\User;
use App\Models\CryptoHolding;
use App\Models\FiatHolding;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class TransactionsController extends ApiController
{
    /**
     * Get all transactions
     */
    public function index(): JsonResponse
    {
        try {
            $transactions = Transaction::with(['user:id,username,email,first_name,last_name', 'withdrawalRequest:id,rejection_reason'])
                ->select([
                    'id',
                    'user_id',
                    'withdrawal_request_id',
                    'type',
                    'asset',
                    'amount',
                    'amount_usd',
                    'status',
                    'wallet_address',
                    'transaction_hash',
                    'notes',
                    'date_time',
                    'created_at'
                ])
                ->orderBy('date_time', 'desc')
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($transaction) {
                    $userName = 'N/A';
                    if ($transaction->user) {
                        $firstName = $transaction->user->first_name ?? '';
                        $lastName = $transaction->user->last_name ?? '';
                        $userName = trim($firstName . ' ' . $lastName) ?: $transaction->user->username ?? 'N/A';
                    }
                    
                    return [
                        'id' => $transaction->id,
                        'user_id' => $transaction->user_id,
                        'withdrawal_request_id' => $transaction->withdrawal_request_id,
                        'user_name' => $userName,
                        'type' => $transaction->type,
                        'asset' => $transaction->asset,
                        'amount' => $transaction->amount,
                        'amount_usd' => $transaction->amount_usd,
                        'status' => $transaction->status,
                        'wallet_address' => $transaction->wallet_address,
                        'transaction_hash' => $transaction->transaction_hash,
                        'notes' => $transaction->notes,
                        'rejection_reason' => $transaction->withdrawalRequest->rejection_reason ?? null,
                        'date_time' => $transaction->date_time,
                        'created_at' => $transaction->created_at,
                    ];
                });

            return $this->success([
                'transactions' => $transactions
            ], 'Transactions retrieved successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to retrieve transactions: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Create a new transaction
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'type' => 'required|in:deposit,withdrawal',
                'asset' => 'required|string|max:10',
                'amount' => 'required|numeric|min:0',
                'status' => 'required|in:pending,completed,failed,cancelled',
                'wallet_address' => 'nullable|string|max:255',
                'notes' => 'nullable|string|max:1000',
            ]);

            // Calculate amount_usd using crypto prices
            $amountUSD = $this->calculateAmountUSD($validated['asset'], $validated['amount']);

            $transaction = Transaction::create([
                'user_id' => $validated['user_id'],
                'type' => $validated['type'],
                'asset' => $validated['asset'],
                'amount' => $validated['amount'],
                'amount_usd' => $amountUSD,
                'status' => $validated['status'],
                'wallet_address' => $validated['wallet_address'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'date_time' => now(),
            ]);

            // Update user holdings if transaction is completed
            if ($validated['status'] === 'completed') {
                $this->updateUserHoldings($validated['user_id'], $validated['asset'], $validated['type'], $validated['amount'], $amountUSD);
            }

            return $this->success([
                'transaction' => $transaction
            ], 'Transaction created successfully', 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->error('Validation failed', 422, $e->errors());
        } catch (\Exception $e) {
            return $this->error('Failed to create transaction: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Calculate USD amount for a given asset and amount
     */
    private function calculateAmountUSD(string $asset, float $amount): float
    {
        // Fiat currencies (1:1 for USD, use exchange rates for others)
        $fiatRates = [
            'USD' => 1.0,
            'EUR' => 1.1, // Approximate
            'GBP' => 1.27, // Approximate
            'CAD' => 0.74, // Approximate
        ];

        if (isset($fiatRates[$asset])) {
            return $amount * $fiatRates[$asset];
        }

        // Crypto currencies - fetch from CoinGecko
        try {
            $cryptoIds = [
                'BTC' => 'bitcoin',
                'ETH' => 'ethereum',
                'TRX' => 'tron',
                'USDT' => 'tether',
            ];

            if (!isset($cryptoIds[$asset])) {
                return 0;
            }

            $response = Http::timeout(10)->get('https://api.coingecko.com/api/v3/simple/price', [
                'ids' => $cryptoIds[$asset],
                'vs_currencies' => 'usd',
            ]);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data[$cryptoIds[$asset]]['usd'])) {
                    $price = (float) $data[$cryptoIds[$asset]]['usd'];
                    return $amount * $price;
                } else {
                    \Log::warning("CoinGecko API: Price not found for {$asset}. Response: " . json_encode($data));
                }
            } else {
                \Log::warning("CoinGecko API failed for {$asset}. Status: " . $response->status());
            }
        } catch (\Exception $e) {
            \Log::error("Failed to calculate USD for {$asset}: " . $e->getMessage());
        }

        return 0;
    }

    /**
     * Update user holdings based on transaction
     */
    private function updateUserHoldings(int $userId, string $asset, string $type, float $amount, float $amountUSD): void
    {
        // Determine if asset is crypto or fiat
        $cryptoAssets = ['BTC', 'ETH', 'TRX', 'USDT'];
        $fiatAssets = ['USD', 'EUR', 'GBP', 'CAD'];
        
        $isCrypto = in_array($asset, $cryptoAssets);
        $isFiat = in_array($asset, $fiatAssets);
        
        if (!$isCrypto && !$isFiat) {
            return; // Unknown asset type
        }

        if ($isCrypto) {
            $holding = CryptoHolding::where('user_id', $userId)
                ->where('symbol', $asset)
                ->first();
            
            if (!$holding) {
                // Create holding if it doesn't exist
                $holding = CryptoHolding::create([
                    'user_id' => $userId,
                    'symbol' => $asset,
                    'balance' => 0,
                    'value_usd' => 0,
                    'allocation_percentage' => 0,
                ]);
            }
            
            if ($type === 'deposit') {
                $holding->balance += $amount;
            } elseif ($type === 'withdrawal') {
                $holding->balance = max(0, $holding->balance - $amount);
            }
            
            // Update value_usd using current price
            $currentPrice = $this->getCurrentCryptoPrice($asset);
            $holding->value_usd = (float) $holding->balance * $currentPrice;
            
            $holding->save();
            
            // Update allocation percentages for all holdings
            $this->updateAllocationPercentages($userId);
        } else {
            $holding = FiatHolding::where('user_id', $userId)
                ->where('symbol', $asset)
                ->first();
            
            if (!$holding) {
                // Create holding if it doesn't exist
                $holding = FiatHolding::create([
                    'user_id' => $userId,
                    'symbol' => $asset,
                    'balance' => 0,
                    'value_usd' => 0,
                    'allocation_percentage' => 0,
                ]);
            }
            
            if ($type === 'deposit') {
                $holding->balance += $amount;
            } elseif ($type === 'withdrawal') {
                $holding->balance = max(0, $holding->balance - $amount);
            }
            
            // For fiat, value_usd is the balance converted to USD
            $fiatRates = [
                'USD' => 1.0,
                'EUR' => 1.1,
                'GBP' => 1.27,
                'CAD' => 0.74,
            ];
            $rate = $fiatRates[$asset] ?? 1.0;
            $holding->value_usd = (float) $holding->balance * $rate;
            
            $holding->save();
            
            // Update allocation percentages for all holdings
            $this->updateAllocationPercentages($userId);
        }
    }

    /**
     * Update allocation percentages for all user holdings
     */
    private function updateAllocationPercentages(int $userId): void
    {
        // Get all crypto holdings with current prices
        $cryptoHoldings = CryptoHolding::where('user_id', $userId)->get();
        $cryptoPrices = [];
        foreach (['BTC', 'ETH', 'TRX', 'USDT'] as $symbol) {
            $cryptoPrices[$symbol] = $this->getCurrentCryptoPrice($symbol);
        }
        
        $totalCryptoUSD = 0;
        foreach ($cryptoHoldings as $holding) {
            $price = $cryptoPrices[$holding->symbol] ?? 0;
            $holding->value_usd = (float) $holding->balance * $price;
            $totalCryptoUSD += $holding->value_usd;
            $holding->save();
        }
        
        // Get all fiat holdings
        $fiatHoldings = FiatHolding::where('user_id', $userId)->get();
        $fiatRates = [
            'USD' => 1.0,
            'EUR' => 1.1,
            'GBP' => 1.27,
            'CAD' => 0.74,
        ];
        
        $totalFiatUSD = 0;
        foreach ($fiatHoldings as $holding) {
            $rate = $fiatRates[$holding->symbol] ?? 1.0;
            $holding->value_usd = (float) $holding->balance * $rate;
            $totalFiatUSD += $holding->value_usd;
            $holding->save();
        }
        
        $totalPortfolio = $totalCryptoUSD + $totalFiatUSD;
        if ($totalPortfolio > 0) {
            // Update crypto allocations
            foreach ($cryptoHoldings as $holding) {
                $holding->allocation_percentage = ($holding->value_usd / $totalPortfolio) * 100;
                $holding->save();
            }
            
            // Update fiat allocations
            foreach ($fiatHoldings as $holding) {
                $holding->allocation_percentage = ($holding->value_usd / $totalPortfolio) * 100;
                $holding->save();
            }
        }
    }

    /**
     * Get current crypto price
     */
    private function getCurrentCryptoPrice(string $asset): float
    {
        try {
            $cryptoIds = [
                'BTC' => 'bitcoin',
                'ETH' => 'ethereum',
                'TRX' => 'tron',
                'USDT' => 'tether',
            ];

            if (!isset($cryptoIds[$asset])) {
                return 0;
            }

            $response = Http::timeout(10)->get('https://api.coingecko.com/api/v3/simple/price', [
                'ids' => $cryptoIds[$asset],
                'vs_currencies' => 'usd',
            ]);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data[$cryptoIds[$asset]]['usd'])) {
                    return (float) $data[$cryptoIds[$asset]]['usd'];
                }
            } else {
                \Log::warning("CoinGecko API failed for {$asset}. Status: " . $response->status());
            }
        } catch (\Exception $e) {
            \Log::error("Failed to fetch price for {$asset}: " . $e->getMessage());
        }

        return 0;
    }

    /**
     * Update transaction status
     */
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $validated = $request->validate([
                'status' => 'required|in:pending,completed,failed,cancelled',
                'rejection_reason' => 'nullable|string|max:1000',
                'transaction_hash' => 'nullable|string|max:255',
            ]);

            $transaction = Transaction::findOrFail($id);

            // Update transaction status
            $transaction->status = $validated['status'];
            if (isset($validated['transaction_hash'])) {
                $transaction->transaction_hash = $validated['transaction_hash'];
            }
            $transaction->save();

            // If transaction has a withdrawal request, update it too
            if ($transaction->withdrawal_request_id) {
                $withdrawalRequest = WithdrawalRequest::find($transaction->withdrawal_request_id);
                if ($withdrawalRequest) {
                    $withdrawalRequest->status = $validated['status'] === 'completed' ? 'confirmed' : 
                                                  ($validated['status'] === 'failed' || $validated['status'] === 'cancelled' ? 'rejected' : 'pending');
                    
                    if ($validated['status'] === 'completed') {
                        $withdrawalRequest->confirmed_at = now();
                        $withdrawalRequest->confirmed_by = auth()->id();
                    } elseif ($validated['status'] === 'failed' || $validated['status'] === 'cancelled') {
                        $withdrawalRequest->rejected_at = now();
                        $withdrawalRequest->rejected_by = auth()->id();
                        if (isset($validated['rejection_reason'])) {
                            $withdrawalRequest->rejection_reason = $validated['rejection_reason'];
                        }
                    }
                    
                    if (isset($validated['transaction_hash'])) {
                        $withdrawalRequest->transaction_hash = $validated['transaction_hash'];
                    }
                    
                    $withdrawalRequest->save();
                }
            }

            // For withdrawals: balance is already deducted when request is created
            // If rejected/cancelled, we need to add the balance back
            // If completed, balance stays deducted (already done)
            if ($transaction->type === 'withdrawal') {
                if ($validated['status'] === 'failed' || $validated['status'] === 'cancelled') {
                    // Add balance back since withdrawal was rejected
                    $this->updateUserHoldings($transaction->user_id, $transaction->asset, 'deposit', $transaction->amount, $transaction->amount_usd);
                }
                // If status is 'completed', balance was already deducted when request was created, so do nothing
            } elseif ($validated['status'] === 'completed') {
                // For deposits, update holdings when completed
                $this->updateUserHoldings($transaction->user_id, $transaction->asset, $transaction->type, $transaction->amount, $transaction->amount_usd);
            }

            return $this->success([
                'transaction' => $transaction->fresh(['user', 'withdrawalRequest'])
            ], 'Transaction updated successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->error('Validation failed', 422, $e->errors());
        } catch (\Exception $e) {
            return $this->error('Failed to update transaction: ' . $e->getMessage(), 500);
        }
    }
}

