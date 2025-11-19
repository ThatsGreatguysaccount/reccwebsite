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
            
            // Validate that USD value was calculated successfully
            if ($amountUSD <= 0 && $validated['amount'] > 0) {
                \Log::error("Failed to calculate USD value for withdrawal. Asset: {$validated['asset']}, Amount: {$validated['amount']}");
                
                // Try one more time with a fresh API call
                $amountUSD = $this->calculateAmountUSD($validated['asset'], $validated['amount']);
                
                if ($amountUSD <= 0) {
                    return $this->error('Failed to calculate USD value for withdrawal. Please try again.', 500);
                }
            }

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
     * Uses cached prices to avoid rate limiting
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

            // Try to get price from cache first (shared cache from getCryptoPrices)
            $cacheKey = 'crypto_prices_simple';
            $cachedPrices = \Cache::get($cacheKey);
            if ($cachedPrices !== null && is_array($cachedPrices) && isset($cachedPrices[$asset]) && $cachedPrices[$asset] > 0) {
                $price = (float) $cachedPrices[$asset];
                \Log::info("Using cached price for {$asset}: {$price}");
                return $amount * $price;
            }

            // Try to get price from existing holding (fallback)
            $holding = CryptoHolding::where('user_id', request()->user()->id)
                ->where('symbol', $asset)
                ->first();
            
            $fallbackPrice = 0;
            if ($holding && $holding->balance > 0) {
                if ($holding->value_usd > 0) {
                    $fallbackPrice = (float) $holding->value_usd / (float) $holding->balance;
                    \Log::info("Using fallback price for {$asset}: {$fallbackPrice} from existing holding (value_usd: {$holding->value_usd}, balance: {$holding->balance})");
                } else {
                    // If value_usd is 0, try to update it first
                    \Log::warning("Holding for {$asset} has value_usd = 0, attempting to fetch price to update it");
                    $tempPrice = $this->getCurrentCryptoPrice($asset);
                    if ($tempPrice > 0) {
                        $holding->value_usd = (float) $holding->balance * $tempPrice;
                        $holding->save();
                        $fallbackPrice = $tempPrice;
                        \Log::info("Updated holding value_usd and using price: {$fallbackPrice}");
                    }
                }
            }

            // If cache miss, fetch from API (this will also update the cache)
            $response = Http::timeout(15)
                ->retry(3, 1000) // Retry 3 times with 1 second delay
                ->withOptions([
                    'verify' => true, // Always verify SSL certificates for security
                ])
                ->get('https://api.coingecko.com/api/v3/simple/price', [
                    'ids' => $coinId,
                    'vs_currencies' => 'usd',
                ]);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data[$coinId]['usd'])) {
                    $price = (float) $data[$coinId]['usd'];
                    \Log::info("Successfully fetched price for {$asset}: {$price}");
                    
                    // Update cache with the fetched price (update existing cache or create new)
                    $cachedPrices = \Cache::get($cacheKey, []);
                    if (!is_array($cachedPrices)) {
                        $cachedPrices = [];
                    }
                    $cachedPrices[$asset] = $price;
                    \Cache::put($cacheKey, $cachedPrices, 60); // Cache for 1 minute
                    
                    // Update holding's value_usd if available (for future fallback use)
                    if ($holding && $holding->balance > 0) {
                        $holding->value_usd = (float) $holding->balance * $price;
                        $holding->save();
                        \Log::info("Updated holding value_usd for {$asset} to {$holding->value_usd}");
                    }
                    
                    return $amount * $price;
                } else {
                    \Log::warning("CoinGecko API: Price not found for {$asset} (ID: {$coinId}). Response: " . json_encode($data));
                    if ($fallbackPrice > 0) {
                        \Log::info("Using fallback price for {$asset}: {$fallbackPrice}");
                        return $amount * $fallbackPrice;
                    }
                }
            } else {
                \Log::warning("CoinGecko API failed for {$asset}. Status: " . $response->status() . ", Body: " . $response->body());
                if ($fallbackPrice > 0) {
                    \Log::info("Using fallback price for {$asset} due to API failure: {$fallbackPrice}");
                    return $amount * $fallbackPrice;
                }
            }
        } catch (\Exception $e) {
            \Log::error("Failed to calculate USD for {$asset}: " . $e->getMessage() . " | Trace: " . $e->getTraceAsString());
            
            // Try fallback price
            $holding = CryptoHolding::where('user_id', request()->user()->id)
                ->where('symbol', $asset)
                ->first();
            
            if ($holding && $holding->balance > 0 && $holding->value_usd > 0) {
                $fallbackPrice = (float) $holding->value_usd / (float) $holding->balance;
                \Log::info("Using fallback price for {$asset} after exception: {$fallbackPrice}");
                return $amount * $fallbackPrice;
            }
        }

        \Log::error("Failed to calculate USD for {$asset}: No price available and no fallback");
        return 0;
    }

    /**
     * Get current crypto price from CoinGecko
     * Uses cached prices to avoid rate limiting
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

            // Try to get price from cache first (shared cache from getCryptoPrices)
            $cacheKey = 'crypto_prices_simple';
            $cachedPrices = \Cache::get($cacheKey);
            if ($cachedPrices !== null && is_array($cachedPrices) && isset($cachedPrices[$asset]) && $cachedPrices[$asset] > 0) {
                $price = (float) $cachedPrices[$asset];
                \Log::info("Using cached price for {$asset}: {$price}");
                return $price;
            }

            // Try to get price from existing holding (fallback)
            $holding = CryptoHolding::where('user_id', request()->user()->id)
                ->where('symbol', $asset)
                ->first();
            
            $fallbackPrice = 0;
            if ($holding && $holding->balance > 0 && $holding->value_usd > 0) {
                $fallbackPrice = (float) $holding->value_usd / (float) $holding->balance;
            }

            // If cache miss, fetch from API (this will also update the cache)
            $response = Http::timeout(15)
                ->retry(3, 1000) // Retry 3 times with 1 second delay
                ->withOptions([
                    'verify' => true, // Always verify SSL certificates for security
                ])
                ->get('https://api.coingecko.com/api/v3/simple/price', [
                    'ids' => $coinId,
                    'vs_currencies' => 'usd',
                ]);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data[$coinId]['usd'])) {
                    $price = (float) $data[$coinId]['usd'];
                    \Log::info("Successfully fetched current price for {$asset}: {$price}");
                    
                    // Update cache with the fetched price (update existing cache or create new)
                    $cachedPrices = \Cache::get($cacheKey, []);
                    if (!is_array($cachedPrices)) {
                        $cachedPrices = [];
                    }
                    $cachedPrices[$asset] = $price;
                    \Cache::put($cacheKey, $cachedPrices, 60); // Cache for 1 minute
                    
                    return $price;
                } else {
                    \Log::warning("CoinGecko API: Price not found for {$asset} (ID: {$coinId}). Response: " . json_encode($data));
                    if ($fallbackPrice > 0) {
                        \Log::info("Using fallback price for {$asset}: {$fallbackPrice}");
                        return $fallbackPrice;
                    }
                }
            } else {
                \Log::warning("CoinGecko API failed for {$asset}. Status: " . $response->status() . ", Body: " . $response->body());
                if ($fallbackPrice > 0) {
                    \Log::info("Using fallback price for {$asset} due to API failure: {$fallbackPrice}");
                    return $fallbackPrice;
                }
            }
        } catch (\Exception $e) {
            \Log::error("Failed to fetch price for {$asset}: " . $e->getMessage() . " | Trace: " . $e->getTraceAsString());
            
            // Try fallback price
            $holding = CryptoHolding::where('user_id', request()->user()->id)
                ->where('symbol', $asset)
                ->first();
            
            if ($holding && $holding->balance > 0 && $holding->value_usd > 0) {
                $fallbackPrice = (float) $holding->value_usd / (float) $holding->balance;
                \Log::info("Using fallback price for {$asset} after exception: {$fallbackPrice}");
                return $fallbackPrice;
            }
        }

        \Log::error("Failed to fetch price for {$asset}: No price available and no fallback");
        return 0;
    }

    /**
     * Update allocation percentages for all user holdings
     * Uses cached prices to avoid rate limiting
     */
    private function updateAllocationPercentages(int $userId): void
    {
        // Get all crypto holdings with current prices
        $cryptoHoldings = CryptoHolding::where('user_id', $userId)->get();
        $cryptoPrices = [];
        
        // Try to get prices from cache first
        $cacheKey = 'crypto_prices_simple';
        $cachedPrices = \Cache::get($cacheKey);
        if ($cachedPrices !== null && is_array($cachedPrices)) {
            $cryptoPrices = $cachedPrices;
            \Log::info('Using cached prices for allocation update');
        } else {
            // If cache miss, fetch from API (this will also update the cache)
            try {
                $response = Http::timeout(15)
                    ->retry(3, 1000)
                    ->withOptions([
                        'verify' => true, // Always verify SSL certificates for security
                    ])
                    ->get('https://api.coingecko.com/api/v3/simple/price', [
                        'ids' => 'bitcoin,ethereum,tron,tether',
                        'vs_currencies' => 'usd',
                    ]);
                
                if ($response->successful()) {
                    $data = $response->json();
                    $cryptoPrices = [
                        'BTC' => isset($data['bitcoin']['usd']) ? (float) $data['bitcoin']['usd'] : 0,
                        'ETH' => isset($data['ethereum']['usd']) ? (float) $data['ethereum']['usd'] : 0,
                        'TRX' => isset($data['tron']['usd']) ? (float) $data['tron']['usd'] : 0,
                        'USDT' => isset($data['tether']['usd']) ? (float) $data['tether']['usd'] : 0,
                    ];
                    
                    // Cache the prices for 1 minute
                    \Cache::put($cacheKey, $cryptoPrices, 60);
                }
            } catch (\Exception $e) {
                \Log::error("Failed to fetch bulk crypto prices: " . $e->getMessage());
            }
            
            // Fallback to individual price fetching if bulk failed
            foreach (['BTC', 'ETH', 'TRX', 'USDT'] as $symbol) {
                if (!isset($cryptoPrices[$symbol]) || $cryptoPrices[$symbol] == 0) {
                    $cryptoPrices[$symbol] = $this->getCurrentCryptoPrice($symbol);
                }
            }
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

