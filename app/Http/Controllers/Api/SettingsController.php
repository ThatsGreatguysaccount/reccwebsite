<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class SettingsController extends ApiController
{
    /**
     * Get user settings
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            return $this->success([
                'user' => [
                    'id' => $user->id,
                    'username' => $user->username,
                    'email' => $user->email,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'uid' => $user->uid,
                    'avatar' => $user->avatar,
                    'id_verification_status' => $user->id_verification_status,
                    'bank_verification_status' => $user->bank_verification_status,
                    'front_id' => $user->front_id,
                    'back_id' => $user->back_id,
                    'bank_statement' => $user->bank_statement,
                ],
                'address' => [
                    'country' => $user->country,
                    'address1' => $user->address1,
                    'address2' => $user->address2,
                    'zip_code' => $user->zip_code,
                ],
            ], 'Settings retrieved successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to load settings: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Update user address
     */
    public function updateAddress(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'country' => 'nullable|string|max:255',
                'address1' => 'nullable|string|max:255',
                'address2' => 'nullable|string|max:255',
                'zip_code' => 'nullable|string|max:50',
            ]);

            $user = $request->user();
            $user->update($validated);

            return $this->success([
                'address' => [
                    'country' => $user->country,
                    'address1' => $user->address1,
                    'address2' => $user->address2,
                    'zip_code' => $user->zip_code,
                ],
            ], 'Address updated successfully');
        } catch (ValidationException $e) {
            return $this->error('Validation failed', 422, $e->errors());
        } catch (\Exception $e) {
            return $this->error('Failed to update address: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Upload verification document
     */
    public function uploadDocument(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'type' => 'required|in:front_id,back_id,bank_statement',
                'file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120', // 5MB max
            ]);

            $user = $request->user();
            $file = $request->file('file');
            $type = $validated['type'];

            // Store file
            $path = $file->store('documents/' . $user->id, 'public');
            $url = Storage::url($path);

            // Update user record
            $user->update([$type => $url]);

            return $this->success([
                'url' => $url,
                'type' => $type,
            ], 'Document uploaded successfully');
        } catch (ValidationException $e) {
            return $this->error('Validation failed', 422, $e->errors());
        } catch (\Exception $e) {
            return $this->error('Failed to upload document: ' . $e->getMessage(), 500);
        }
    }
}

