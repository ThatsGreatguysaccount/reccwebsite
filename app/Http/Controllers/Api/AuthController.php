<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\CryptoHolding;
use App\Models\FiatHolding;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends ApiController
{
    /**
     * Register a new user
     */
    public function register(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'username' => 'required|string|max:255|unique:users,username',
                'email' => 'required|string|email|max:255|unique:users,email',
                'password' => 'required|string|min:6|confirmed',
            ]);

            // Generate unique UID
            $uid = User::generateUID();

            // Create user
            $user = User::create([
                'username' => $validated['username'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'uid' => $uid,
            ]);

            // Initialize crypto holdings (BTC, ETH, TRX, USDT)
            $cryptoAssets = ['BTC', 'ETH', 'TRX', 'USDT'];
            foreach ($cryptoAssets as $symbol) {
                CryptoHolding::create([
                    'user_id' => $user->id,
                    'symbol' => $symbol,
                    'balance' => 0.00000000,
                    'value_usd' => 0.00,
                    'allocation_percentage' => 0.00,
                ]);
            }

            // Initialize fiat holdings (USD, EUR, GBP, CAD)
            $fiatAssets = ['USD', 'EUR', 'GBP', 'CAD'];
            foreach ($fiatAssets as $symbol) {
                FiatHolding::create([
                    'user_id' => $user->id,
                    'symbol' => $symbol,
                    'balance' => 0.00,
                    'value_usd' => 0.00,
                    'allocation_percentage' => 0.00,
                ]);
            }

            // Create token
            $token = $user->createToken('auth_token')->plainTextToken;

            return $this->success([
                'user' => [
                    'id' => $user->id,
                    'username' => $user->username,
                    'email' => $user->email,
                    'uid' => $user->uid,
                    'account_type' => $user->account_type ?? 'user',
                ],
                'token' => $token,
            ], 'User registered successfully', 201);
        } catch (ValidationException $e) {
            return $this->error('Validation failed', 422, $e->errors());
        } catch (\Exception $e) {
            return $this->error('Registration failed: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Login user
     */
    public function login(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'username' => 'required|string',
                'password' => 'required|string',
            ]);

            // Find user by username or email
            $user = User::where('username', $request->username)
                ->orWhere('email', $request->username)
                ->first();

            // Check if user exists and password is correct
            if (!$user || !Hash::check($request->password, $user->password)) {
                return $this->error('Invalid credentials', 401);
            }

            // Create token
            $token = $user->createToken('auth_token')->plainTextToken;

            return $this->success([
                'user' => [
                    'id' => $user->id,
                    'username' => $user->username,
                    'email' => $user->email,
                    'uid' => $user->uid,
                    'account_type' => $user->account_type ?? 'user',
                ],
                'token' => $token,
            ], 'Login successful');
        } catch (ValidationException $e) {
            return $this->error('Validation failed', 422, $e->errors());
        } catch (\Exception $e) {
            return $this->error('Login failed: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Logout user
     */
    public function logout(Request $request): JsonResponse
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return $this->success(null, 'Logged out successfully');
        } catch (\Exception $e) {
            return $this->error('Logout failed: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Get authenticated user
     */
    public function me(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            return $this->success([
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'uid' => $user->uid,
            ], 'User retrieved successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to retrieve user: ' . $e->getMessage(), 500);
        }
    }
}

