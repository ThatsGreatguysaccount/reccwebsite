<?php

namespace App\Http\Controllers\Api;

use App\Models\WithdrawalRequest;
use App\Models\Transaction;
use App\Models\CryptoHolding;
use App\Models\FiatHolding;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class WithdrawalController extends ApiController
{
    /**
     * Submit a withdrawal request
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'asset' => 'required|string|max:10',
                'amount' => 'required|numeric|min:0.00000001',
                'type' => 'required|in:crypto,fiat',
                'wallet_address' => 'required_if:type,crypto|nullable|string|max:255',
                'bank_account' => 'required_if:type,fiat|nullable|string',
                'notes' => 'nullable|string',
                'network_fee' => 'nullable|numeric|min:0',
            ]);

            $user = $request->user();

            // Check if user has sufficient balance
            if ($validated['type'] === 'crypto') {
                $holding = \App\Models\CryptoHolding::where('user_id', $user->id)
                    ->where('symbol', $validated['asset'])
                    ->first();

                if (!$holding || $holding->balance < $validated['amount']) {
                    return $this->error('Insufficient balance', 400);
                }
            } else {
                $holding = \App\Models\FiatHolding::where('user_id', $user->id)
                    ->where('symbol', $validated['asset'])
                    ->first();

                if (!$holding || $holding->balance < $validated['amount']) {
                    return $this->error('Insufficient balance', 400);
                }
            }

            // Calculate USD value using current crypto prices
            $amountUSD = $this->calculateAmountUSD($validated['asset'], $validated['amount']);

            // Create withdrawal request
            $withdrawalRequest = WithdrawalRequest::create([
                'user_id' => $user->id,
                'type' => $validated['type'],
                'asset' => $validated['asset'],
                'amount' => $validated['amount'],
                'amount_usd' => $amountUSD,
                'wallet_address' => $validated['wallet_address'] ?? null,
                'bank_account' => $validated['bank_account'] ?? null,
                'network_fee' => $validated['network_fee'] ?? 0,
                'notes' => $validated['notes'] ?? null,
                'status' => 'pending',
            ]);

            // Create corresponding transaction
            Transaction::create([
                'user_id' => $user->id,
                'withdrawal_request_id' => $withdrawalRequest->id,
                'type' => 'withdrawal',
                'asset' => $validated['asset'],
                'amount' => $validated['amount'],
                'amount_usd' => $amountUSD,
                'status' => 'pending',
                'wallet_address' => $validated['wallet_address'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'date_time' => now(),
            ]);

            // Deduct balance immediately when withdrawal request is created
            if ($validated['type'] === 'crypto') {
                $cryptoHolding = CryptoHolding::where('user_id', $user->id)
                    ->where('symbol', $validated['asset'])
                    ->first();
                
                if ($cryptoHolding) {
                    $cryptoHolding->balance = max(0, $cryptoHolding->balance - $validated['amount']);
                    
                    // Update value_usd using current price
                    $currentPrice = $this->getCurrentCryptoPrice($validated['asset']);
                    $cryptoHolding->value_usd = (float) $cryptoHolding->balance * $currentPrice;
                    
                    $cryptoHolding->save();
                }
            } else {
                $fiatHolding = FiatHolding::where('user_id', $user->id)
                    ->where('symbol', $validated['asset'])
                    ->first();
                
                if ($fiatHolding) {
                    $fiatHolding->balance = max(0, $fiatHolding->balance - $validated['amount']);
                    
                    // For fiat, value_usd is the balance converted to USD
                    $fiatRates = [
                        'USD' => 1.0,
                        'EUR' => 1.1,
                        'GBP' => 1.27,
                        'CAD' => 0.74,
                    ];
                    $rate = $fiatRates[$validated['asset']] ?? 1.0;
                    $fiatHolding->value_usd = (float) $fiatHolding->balance * $rate;
                    
                    $fiatHolding->save();
                }
            }
            
            // Update allocation percentages after balance change
            $this->updateAllocationPercentages($user->id);

            return $this->success([
                'request' => [
                    'id' => $withdrawalRequest->id,
                    'type' => $withdrawalRequest->type,
                    'asset' => $withdrawalRequest->asset,
                    'amount' => (float) $withdrawalRequest->amount,
                    'status' => $withdrawalRequest->status,
                ],
            ], 'Withdrawal request submitted successfully', 201);
        } catch (ValidationException $e) {
            return $this->error('Validation failed', 422, $e->errors());
        } catch (\Exception $e) {
            return $this->error('Failed to submit withdrawal request: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Calculate USD value for crypto amount
     */
    private function calculateAmountUSD(string $asset, float $amount): float
    {
        try {
            $coinGeckoIds = [
                'BTC' => 'bitcoin',
                'ETH' => 'ethereum',
                'TRX' => 'tron',
                'USDT' => 'tether',
            ];

            $coinId = $coinGeckoIds[$asset] ?? null;
            if (!$coinId) {
                return $amount; // For fiat, return as is
            }

            $response = Http::timeout(10)->get('https://api.coingecko.com/api/v3/simple/price', [
                'ids' => $coinId,
                'vs_currencies' => 'usd',
            ]);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data[$coinId]['usd'])) {
                    $price = (float) $data[$coinId]['usd'];
                    return $amount * $price;
                } else {
                    \Log::warning("CoinGecko API: Price not found for {$asset} (ID: {$coinId}). Response: " . json_encode($data));
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
     * Get current crypto price from CoinGecko
     */
    private function getCurrentCryptoPrice(string $asset): float
    {
        try {
            $coinGeckoIds = [
                'BTC' => 'bitcoin',
                'ETH' => 'ethereum',
                'TRX' => 'tron',
                'USDT' => 'tether',
            ];

            $coinId = $coinGeckoIds[$asset] ?? null;
            if (!$coinId) {
                return 0;
            }

            $response = Http::timeout(10)->get('https://api.coingecko.com/api/v3/simple/price', [
                'ids' => $coinId,
                'vs_currencies' => 'usd',
            ]);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data[$coinId]['usd'])) {
                    return (float) $data[$coinId]['usd'];
                }
            }
        } catch (\Exception $e) {
            \Log::error("Failed to fetch price for {$asset}: " . $e->getMessage());
        }

        return 0;
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
        
        // Update allocation percentages for crypto holdings
        foreach ($cryptoHoldings as $holding) {
            $holding->allocation_percentage = $totalPortfolio > 0 
                ? ($holding->value_usd / $totalPortfolio) * 100 
                : 0;
            $holding->save();
        }
        
        // Update allocation percentages for fiat holdings
        foreach ($fiatHoldings as $holding) {
            $holding->allocation_percentage = $totalPortfolio > 0 
                ? ($holding->value_usd / $totalPortfolio) * 100 
                : 0;
            $holding->save();
        }
    }
}

