<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class PasswordController extends ApiController
{
    /**
     * Change user password
     */
    public function change(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'old_password' => 'required|string',
                'new_password' => 'required|string|min:6|confirmed',
            ]);

            $user = $request->user();

            // Verify old password
            if (!Hash::check($validated['old_password'], $user->password)) {
                return $this->error('Current password is incorrect', 422);
            }

            // Update password
            $user->update([
                'password' => Hash::make($validated['new_password']),
            ]);

            return $this->success(null, 'Password changed successfully');
        } catch (ValidationException $e) {
            return $this->error('Validation failed', 422, $e->errors());
        } catch (\Exception $e) {
            return $this->error('Failed to change password: ' . $e->getMessage(), 500);
        }
    }
}

