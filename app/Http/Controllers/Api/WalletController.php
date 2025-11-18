<?php

namespace App\Http\Controllers\Api;

use App\Models\Transaction;
use App\Models\WalletAddress;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WalletController extends ApiController
{
    /**
     * Get wallet data for authenticated user
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            // Get wallet addresses from database
            $walletAddresses = WalletAddress::where('user_id', $user->id)
                ->get()
                ->keyBy('symbol');

            // Always return all 4 crypto wallets, even if addresses don't exist
            $cryptoList = ['BTC', 'ETH', 'TRX', 'USDT'];
            $wallets = collect($cryptoList)->map(function ($symbol) use ($walletAddresses) {
                $wallet = $walletAddresses->get($symbol);
                return [
                    'symbol' => $symbol,
                    'name' => $this->getCryptoName($symbol),
                    'icon' => $this->getCryptoIcon($symbol),
                    'chain' => $this->getCryptoChain($symbol),
                    'address' => $wallet ? $wallet->address : null,
                ];
            });

            // Get all transactions
            $transactions = Transaction::where('user_id', $user->id)
                ->orderBy('date_time', 'desc')
                ->get()
                ->map(function ($transaction) {
                    return [
                        'id' => $transaction->id,
                        'type' => $transaction->type,
                        'asset' => $transaction->asset,
                        'amount' => (float) $transaction->amount,
                        'amountUSD' => (float) $transaction->amount_usd,
                        'status' => $transaction->status,
                        'wallet_address' => $transaction->wallet_address,
                        'transaction_hash' => $transaction->transaction_hash,
                        'date' => $transaction->date_time,
                    ];
                });

            return $this->success([
                'wallets' => $wallets,
                'transactions' => $transactions,
            ], 'Wallet data retrieved successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to load wallet data: ' . $e->getMessage(), 500);
        }
    }

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

    private function getCryptoChain(string $symbol): string
    {
        $chains = [
            'BTC' => 'Blockchain',
            'ETH' => 'Ethereum',
            'TRX' => 'Tron',
            'USDT' => 'Ethereum',
        ];
        return $chains[$symbol] ?? '';
    }
}

