<?php

namespace App\Http\Controllers\Api;

use App\Models\CryptoHolding;
use App\Models\FiatHolding;
use App\Models\Transaction;
use App\Models\WithdrawalRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends ApiController
{
    /**
     * Get dashboard data for authenticated user
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            // Get current crypto prices
            $cryptoPrices = $this->getCryptoPrices();

            // Get crypto holdings - ensure all 4 are always returned
            $cryptoAssets = ['BTC', 'ETH', 'TRX', 'USDT'];
            $existingCryptoHoldings = CryptoHolding::where('user_id', $user->id)
                ->get()
                ->keyBy('symbol');
            
            $cryptoHoldings = collect($cryptoAssets)->map(function ($symbol) use ($existingCryptoHoldings, $cryptoPrices) {
                $holding = $existingCryptoHoldings->get($symbol);
                $price = $cryptoPrices[$symbol] ?? 0;
                $balance = $holding ? (float) $holding->balance : 0.0;
                
                // If price is 0, try to fetch it again or use stored value_usd
                if ($price == 0 && $holding && $holding->value_usd > 0 && $balance > 0) {
                    // Calculate price from stored value_usd
                    $price = (float) $holding->value_usd / $balance;
                }
                
                $valueUSD = $balance * $price;
                
                return [
                    'symbol' => $symbol,
                    'name' => $this->getCryptoName($symbol),
                    'icon' => $this->getCryptoIcon($symbol),
                    'balance' => $balance,
                    'valueUSD' => $valueUSD,
                    'price' => $price,
                    'allocation' => 0, // Will be calculated later
                ];
            });

            // Get fiat holdings - ensure all 4 are always returned
            $fiatAssets = ['USD', 'EUR', 'GBP', 'CAD'];
            $existingFiatHoldings = FiatHolding::where('user_id', $user->id)
                ->get()
                ->keyBy('symbol');
            
            $fiatHoldings = collect($fiatAssets)->map(function ($symbol) use ($existingFiatHoldings) {
                $holding = $existingFiatHoldings->get($symbol);
                $balance = $holding ? (float) $holding->balance : 0.0;
                
                // Calculate USD value
                $fiatRates = [
                    'USD' => 1.0,
                    'EUR' => 1.1,
                    'GBP' => 1.27,
                    'CAD' => 0.74,
                ];
                $rate = $fiatRates[$symbol] ?? 1.0;
                $valueUSD = $balance * $rate;
                
                return [
                    'symbol' => $symbol,
                    'name' => $this->getFiatName($symbol),
                    'icon' => $this->getFiatIcon($symbol),
                    'balance' => $balance,
                    'valueUSD' => $valueUSD,
                    'allocation' => 0, // Will be calculated later
                ];
            });

            // Calculate totals
            $totalCryptoUSD = $cryptoHoldings->sum('valueUSD');
            $totalFiatUSD = $fiatHoldings->sum('valueUSD');
            $totalBalance = $totalCryptoUSD + $totalFiatUSD;

            // Get transaction statistics
            $totalDeposits = Transaction::where('user_id', $user->id)
                ->where('type', 'deposit')
                ->where('status', 'completed')
                ->sum('amount_usd');

            $totalWithdrawals = Transaction::where('user_id', $user->id)
                ->where('type', 'withdrawal')
                ->where('status', 'completed')
                ->sum('amount_usd');

            $totalTransactions = Transaction::where('user_id', $user->id)->count();

            // Get recent transactions
            $recentTransactions = Transaction::where('user_id', $user->id)
                ->orderBy('date_time', 'desc')
                ->limit(10)
                ->get()
                ->map(function ($transaction) {
                    // Get rejection reason from withdrawal request if available
                    $rejectionReason = null;
                    if ($transaction->withdrawal_request_id) {
                        $withdrawalRequest = \App\Models\WithdrawalRequest::find($transaction->withdrawal_request_id);
                        if ($withdrawalRequest) {
                            $rejectionReason = $withdrawalRequest->rejection_reason;
                        }
                    }
                    
                    return [
                        'id' => $transaction->id,
                        'type' => $transaction->type,
                        'asset' => $transaction->asset,
                        'amount' => (float) $transaction->amount,
                        'amountUSD' => (float) $transaction->amount_usd,
                        'status' => $transaction->status,
                        'date' => $transaction->date_time,
                        'wallet_address' => $transaction->wallet_address,
                        'transaction_hash' => $transaction->transaction_hash,
                        'rejection_reason' => $rejectionReason,
                    ];
                });

            // Get user balances for quick access
            $balances = [];
            foreach ($cryptoHoldings as $holding) {
                $balances[$holding['symbol']] = $holding['balance'];
            }

            // Calculate allocation percentages
            $totalPortfolio = $totalBalance > 0 ? $totalBalance : 1;
            $cryptoHoldings = $cryptoHoldings->map(function ($holding) use ($totalPortfolio) {
                $holding['allocation'] = ($holding['valueUSD'] / $totalPortfolio) * 100;
                return $holding;
            });
            
            $fiatHoldings = $fiatHoldings->map(function ($holding) use ($totalPortfolio) {
                $holding['allocation'] = ($holding['valueUSD'] / $totalPortfolio) * 100;
                return $holding;
            });

            return $this->success([
                'user' => [
                    'id' => $user->id,
                    'username' => $user->username,
                    'email' => $user->email,
                    'uid' => $user->uid,
                    'fullName' => trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? '')) ?: $user->username,
                    'avatar' => $user->avatar ?: '/customer/images/user.png',
                ],
                'balances' => $balances,
                'cryptoHoldings' => $cryptoHoldings,
                'fiatHoldings' => $fiatHoldings,
                'cryptoPrices' => $cryptoPrices,
                'totalBalance' => $totalBalance,
                'totalDeposits' => (float) $totalDeposits,
                'totalWithdrawals' => (float) $totalWithdrawals,
                'availableBalance' => $totalBalance,
                'totalTransactions' => $totalTransactions,
                'recentTransactions' => $recentTransactions,
            ], 'Dashboard data retrieved successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to load dashboard data: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Get withdrawal requests for authenticated user
     */
    public function withdrawalRequests(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            $requests = WithdrawalRequest::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($request) {
                    return [
                        'id' => $request->id,
                        'type' => $request->type,
                        'asset' => $request->asset,
                        'amount' => (float) $request->amount,
                        'amountUSD' => (float) $request->amount_usd,
                        'wallet_address' => $request->wallet_address,
                        'bank_account' => $request->bank_account,
                        'status' => $request->status,
                        'rejection_reason' => $request->rejection_reason,
                        'notes' => $request->notes,
                        'created_at' => $request->created_at,
                        'confirmed_at' => $request->confirmed_at,
                        'rejected_at' => $request->rejected_at,
                    ];
                });

            return $this->success([
                'requests' => $requests,
            ], 'Withdrawal requests retrieved successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to load withdrawal requests: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Get crypto prices from CoinGecko API
     */
    public function cryptoPrices(): JsonResponse
    {
        $cacheKey = 'crypto_prices_detailed';
        $cacheDuration = 60; // 1 minute cache to avoid rate limiting
        
        // Try to get from cache first
        $cachedData = \Cache::get($cacheKey);
        if ($cachedData !== null && is_array($cachedData)) {
            \Log::info('Using cached detailed crypto prices');
            return $this->success([
                'prices' => $cachedData,
            ], 'Crypto prices retrieved successfully (cached)');
        }
        
        try {
            // Using CoinGecko free API with more data
            $response = Http::timeout(15)
                ->retry(3, 1000) // Retry 3 times with 1 second delay
                ->withOptions([
                    'verify' => true, // Always verify SSL certificates for security
                ])
                ->get('https://api.coingecko.com/api/v3/simple/price', [
                    'ids' => 'bitcoin,ethereum,tron,tether',
                    'vs_currencies' => 'usd',
                    'include_market_cap' => 'true',
                    'include_24hr_change' => 'true',
                    'include_24hr_vol' => 'true',
                ]);

            if ($response->successful()) {
                $data = $response->json();
                
                // Log for debugging
                \Log::info('CoinGecko API Response (cryptoPrices): ' . json_encode($data));
                
                if (!is_array($data) || empty($data)) {
                    return $this->error('CoinGecko API returned empty data', 500);
                }
                
                $prices = [
                    'BTC' => [
                        'price' => isset($data['bitcoin']['usd']) ? (float) $data['bitcoin']['usd'] : 0,
                        'market_cap' => isset($data['bitcoin']['usd_market_cap']) ? (float) $data['bitcoin']['usd_market_cap'] : 0,
                        'change_24h' => isset($data['bitcoin']['usd_24h_change']) ? (float) $data['bitcoin']['usd_24h_change'] : 0,
                        'volume_24h' => isset($data['bitcoin']['usd_24h_vol']) ? (float) $data['bitcoin']['usd_24h_vol'] : 0,
                    ],
                    'ETH' => [
                        'price' => isset($data['ethereum']['usd']) ? (float) $data['ethereum']['usd'] : 0,
                        'market_cap' => isset($data['ethereum']['usd_market_cap']) ? (float) $data['ethereum']['usd_market_cap'] : 0,
                        'change_24h' => isset($data['ethereum']['usd_24h_change']) ? (float) $data['ethereum']['usd_24h_change'] : 0,
                        'volume_24h' => isset($data['ethereum']['usd_24h_vol']) ? (float) $data['ethereum']['usd_24h_vol'] : 0,
                    ],
                    'TRX' => [
                        'price' => isset($data['tron']['usd']) ? (float) $data['tron']['usd'] : 0,
                        'market_cap' => isset($data['tron']['usd_market_cap']) ? (float) $data['tron']['usd_market_cap'] : 0,
                        'change_24h' => isset($data['tron']['usd_24h_change']) ? (float) $data['tron']['usd_24h_change'] : 0,
                        'volume_24h' => isset($data['tron']['usd_24h_vol']) ? (float) $data['tron']['usd_24h_vol'] : 0,
                    ],
                    'USDT' => [
                        'price' => isset($data['tether']['usd']) ? (float) $data['tether']['usd'] : 0,
                        'market_cap' => isset($data['tether']['usd_market_cap']) ? (float) $data['tether']['usd_market_cap'] : 0,
                        'change_24h' => isset($data['tether']['usd_24h_change']) ? (float) $data['tether']['usd_24h_change'] : 0,
                        'volume_24h' => isset($data['tether']['usd_24h_vol']) ? (float) $data['tether']['usd_24h_vol'] : 0,
                    ],
                ];

                // Cache the prices for 1 minute
                \Cache::put($cacheKey, $prices, $cacheDuration);
                \Log::info('Cached detailed crypto prices for ' . $cacheDuration . ' seconds');

                return $this->success([
                    'prices' => $prices,
                ], 'Crypto prices retrieved successfully');
            }

            \Log::warning("CoinGecko API request failed. Status: " . $response->status() . ", Body: " . $response->body());
            return $this->error('Failed to fetch crypto prices. Status: ' . $response->status(), 500);
        } catch (\Exception $e) {
            \Log::error("Failed to fetch crypto prices: " . $e->getMessage());
            return $this->error('Failed to fetch crypto prices: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Get crypto prices for calculations (simplified format)
     * Uses cache to avoid rate limiting (1 minute cache)
     */
    private function getCryptoPrices(): array
    {
        $cacheKey = 'crypto_prices_simple';
        $cacheDuration = 60; // 1 minute cache to avoid rate limiting
        
        // Try to get from cache first
        $cachedPrices = \Cache::get($cacheKey);
        if ($cachedPrices !== null && is_array($cachedPrices)) {
            \Log::info('Using cached crypto prices');
            return $cachedPrices;
        }
        
        try {
            $response = Http::timeout(15)
                ->retry(3, 1000) // Retry 3 times with 1 second delay
                ->withOptions([
                    'verify' => true, // Always verify SSL certificates for security
                ])
                ->get('https://api.coingecko.com/api/v3/simple/price', [
                    'ids' => 'bitcoin,ethereum,tron,tether',
                    'vs_currencies' => 'usd',
                ]);

            if ($response->successful()) {
                $data = $response->json();
                
                // Log the raw response for debugging
                \Log::info('CoinGecko API Response: ' . json_encode($data));
                
                // Check if data is valid
                if (!is_array($data) || empty($data)) {
                    \Log::warning("CoinGecko API returned empty or invalid data");
                    return ['BTC' => 0, 'ETH' => 0, 'TRX' => 0, 'USDT' => 0];
                }
                
                $prices = [
                    'BTC' => isset($data['bitcoin']['usd']) ? (float) $data['bitcoin']['usd'] : 0,
                    'ETH' => isset($data['ethereum']['usd']) ? (float) $data['ethereum']['usd'] : 0,
                    'TRX' => isset($data['tron']['usd']) ? (float) $data['tron']['usd'] : 0,
                    'USDT' => isset($data['tether']['usd']) ? (float) $data['tether']['usd'] : 0,
                ];
                
                // Log if any price is 0 (for debugging)
                foreach ($prices as $symbol => $price) {
                    if ($price == 0) {
                        \Log::warning("Crypto price for {$symbol} is 0 from CoinGecko API. Data: " . json_encode($data[$this->getCoinGeckoId($symbol)] ?? 'not found'));
                    }
                }
                
                // Cache the prices for 1 minute
                \Cache::put($cacheKey, $prices, $cacheDuration);
                \Log::info('Cached crypto prices for ' . $cacheDuration . ' seconds');
                
                return $prices;
            } else {
                \Log::warning("CoinGecko API request failed. Status: " . $response->status() . ", Body: " . $response->body());
            }
        } catch (\Exception $e) {
            \Log::error("Failed to fetch crypto prices: " . $e->getMessage() . " | Trace: " . $e->getTraceAsString());
        }

        return ['BTC' => 0, 'ETH' => 0, 'TRX' => 0, 'USDT' => 0];
    }
    
    /**
     * Get CoinGecko ID for a symbol
     */
    private function getCoinGeckoId(string $symbol): string
    {
        $ids = [
            'BTC' => 'bitcoin',
            'ETH' => 'ethereum',
            'TRX' => 'tron',
            'USDT' => 'tether',
        ];
        return $ids[$symbol] ?? '';
    }

    /**
     * Helper methods
     */
    private function getCryptoName(string $symbol): string
    {
        $names = [
            'BTC' => 'Bitcoin',
            'ETH' => 'Ethereum',
            'TRX' => 'Tron',
            'USDT' => 'Tether',
        ];
        return $names[$symbol] ?? $symbol;
    }

    private function getCryptoIcon(string $symbol): string
    {
        $icons = [
            'BTC' => '/customer/images/bitcoin_mid.png',
            'ETH' => '/customer/images/ethereum_mid.png',
            'TRX' => '/customer/images/tron_med.png',
            'USDT' => '/customer/images/tether_mid.png',
        ];
        return $icons[$symbol] ?? '';
    }

    private function getFiatName(string $symbol): string
    {
        $names = [
            'USD' => 'US Dollar',
            'EUR' => 'Euro',
            'GBP' => 'British Pound',
            'CAD' => 'Canadian Dollar',
        ];
        return $names[$symbol] ?? $symbol;
    }

    private function getFiatIcon(string $symbol): string
    {
        $icons = [
            'USD' => '/customer/images/usd.png',
            'EUR' => '/customer/images/eur.png',
            'GBP' => '/customer/images/gbp.png',
            'CAD' => '/customer/images/cad.png',
        ];
        return $icons[$symbol] ?? '';
    }
}

